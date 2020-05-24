<?php

namespace App\Infrastructure;

use App\Domain\IAdapter;
use App\Domain\IPageRepository;
use App\Domain\ILinkRepository;
use App\Domain\IPageService;
use App\Domain\IParser;
use App\Domain\Link;
use App\Domain\Page;

class PageService implements IPageService
{
    private ILinkRepository $linkRepository;
    private IPageRepository $pageRepository;
    private IParser $parser;
    private IAdapter $adapter;

    public function __construct(
        ILinkRepository $linkRepository,
        IPageRepository $pageRepository,
        IParser $parser,
        IAdapter $adapter
    ) {
        $this->linkRepository = $linkRepository;
        $this->pageRepository = $pageRepository;
        $this->parser = $parser;
        $this->adapter = $adapter;
    }

    public function parsePage(string $url) : void
    {
        $startingTime = microtime(true);
        $this->loadPage($url);
        $pageLoadTime = microtime(true) - $startingTime;

        $page = $this->createPageObject($url, $this->imageCount(), $pageLoadTime);
        $this->pageRepository->addPage($page);
    }

    public function addLinksToCollection(string $url, iterable $links) : void
    {
        foreach ($links as $link) {
            $link = new Link($link, $url);
            if(! $link->isInternal()) {
                continue;
            }

            $this->linkRepository->add($link);
        }
    }

    public function imageCount(): int
    {
        $imageList = $this->parser->getImageList();
        return count($imageList);
    }

    public function loadPage(string $url): void
    {
        $this->parser->loadContent($this->adapter->load($url));
        $links = $this->parser->getLinkList();
        $this->addLinksToCollection($url, $links);
        $this->linkRepository->markVisited($url);
    }

    public function createPageObject(string $url, int $imgQuantity, float $pageLoadTime): Page
    {
        $page = new Page($url);
        $page->setImageCount($imgQuantity);
        $page->setLoadingTime($pageLoadTime);
        return $page;
    }
}