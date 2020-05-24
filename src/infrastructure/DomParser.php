<?php

namespace App\Infrastructure;

use App\Domain\IParser;
use App\Exceptions\DomContextMissingException;

class DomParser implements IParser
{
    protected \DOMDocument $dom;

    public function loadContent(string $content)
    {
        $this->dom = new \DOMDocument();
        @$this->dom->loadHTML($content);
    }

    /**
     * @throws DomContextMissingException
     */
    public function getLinkList() : array
    {
        $this->checkDocumentInit();
        $links = $this->dom->getElementsByTagName('a');

        $elements = [];
        foreach ($links as $link) {
            $href = trim($link->getAttribute('href'));

            if (
                $href === '/' ||
                empty($href) ||
                substr($href, 0, 1) === '#' ||
                substr(strtolower($href),0, 11) === 'javascript:' ||
                ! empty(strstr($href, '@'))
            ) {
                continue;
            }

            $elements[$href] = $href;
        }

        return $elements;
    }

    /**
     * @throws DomContextMissingException
     */
    public function getImageList(): array
    {
        $this->checkDocumentInit();
        $images =  $this->dom->getElementsByTagName('img');

        $imageLinks = [];
        foreach ($images as $image) {
            $src = trim($image->getAttribute('src'));

            if (! empty($src)) {
                $imageLinks[$src] = $src;
            }
        }

        return $imageLinks;
    }

    /**
     * @throws DomContextMissingException
     */
    public function checkDocumentInit(): void
    {
        if (! isset($this->dom)) {
            throw new DomContextMissingException( 'DOM parser has not been initialized');
        }
    }
}