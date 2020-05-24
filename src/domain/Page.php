<?php

namespace App\Domain;

class Page
{
    use UrlTrait;

    protected string $url;
    protected int $imageCount = 0;
    protected float $loadingTime = 0;

    public function __construct(string $url)
    {
        $this->url = $this->purifyUrl($url);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getImageCount(): int
    {
        return $this->imageCount;
    }

    public function setImageCount(int $imageCount): void
    {
        $this->imageCount = $imageCount;
    }

    public function getLoadingTime(): float
    {
        return $this->loadingTime;
    }

    public function setLoadingTime(float $loadingTime): void
    {
        $this->loadingTime = round($loadingTime, 2);
    }
}