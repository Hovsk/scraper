<?php

namespace App\Domain;

class Link
{
    use UrlTrait;

    protected string $href;
    protected string $hostPageUrl;

    public function __construct(string $href, string $hostPageUrl)
    {
        $this->hostPageUrl = $this->purifyUrl($hostPageUrl);
        $this->href = $this->absoluteUrl($href);
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getHostPageUrl(): string
    {
        return $this->hostPageUrl;
    }

    public function isInternal(): bool
    {
        return parse_url($this->getHref())['host'] === parse_url($this->getHostPageUrl())['host'];
    }

    private function absoluteUrl(string $href): string
    {
        $url = parse_url($href);
        $relativeTo = parse_url($this->hostPageUrl);

        if (empty($url['scheme'])) {
            $url['scheme'] = $relativeTo['scheme'];
        }

        if (empty($relativeTo['path'])) {
            $relativeTo['path'] = '';
        }

        if (empty($url['path'])) {
            $url['path'] = '';
        }

        if (empty($url['host'])) {
            $url['host'] = $relativeTo['host'];

            if (substr($url['path'], 0, 1) !== '/') {
                $parts = explode('/', $relativeTo['path']);
                if (count($parts) > 1) {
                    array_pop($parts);
                }
                $base = implode('/', $parts);
                $url['path'] = $base . '/' . $url['path'];
            }
        }

        $absolute = $url['host'] . '/' . trim($url['path'], '/');

        return $url['scheme'] . '://' . $absolute;
    }

}