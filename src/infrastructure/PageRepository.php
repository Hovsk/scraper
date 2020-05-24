<?php

namespace App\Infrastructure;

use App\Domain\IPageRepository;
use App\Domain\Page;

class PageRepository implements IPageRepository
{
    protected array $pages = [];

    public function addPage(Page $page)
    {
        $this->pages[$page->getUrl()] = $page;
    }

    public function sort()
    {
        uasort($this->pages, fn($a, $b) => $b->getImageCount() <=> $a->getImageCount());
    }

    public function getAll()
    {
        return $this->pages;
    }
}