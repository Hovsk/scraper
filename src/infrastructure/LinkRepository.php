<?php

namespace App\Infrastructure;

use App\Domain\ILinkRepository;
use App\Domain\Link;
use App\Exceptions\StackIsEmptyException;

class LinkRepository implements ILinkRepository
{
    protected array $links = [];
    protected array $visitedLinks = [];

    public function add(Link $link): void
    {
        if ($this->isNewLink($link)) {
            $this->links[$link->getHref()] = $link;
        }
    }

    /**
     * @throws StackIsEmptyException
     */
    public function getNextUrl() : string
    {
        if (empty($this->links)) {
            throw new StackIsEmptyException("Stack Is Empty");
        }

        $link = array_pop($this->links);
        return $link->getHref();
    }

    public function isNewLink(Link $link): bool
    {
        return ! isset($this->visitedLinks[$link->getHref()]);
    }

    public function markVisited(string $url): void
    {
        $this->visitedLinks[$url] = $url;
    }

    public function isLinkStackEmpty() : bool
    {
        return empty($this->links);
    }

    public function getAll() : array
    {
        return $this->links;
    }
}