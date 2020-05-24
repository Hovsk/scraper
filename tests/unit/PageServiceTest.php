<?php

use \App\Infrastructure\LinkRepository;
use \App\Infrastructure\PageRepository;
use \App\Infrastructure\PageService;

class PageServiceTest extends \PHPUnit\Framework\TestCase
{
    private LinkRepository $linkRepository;
    private PageRepository $pageRepository;
    private PageService $pageService;

    protected function setUp() : void
    {
        $this->linkRepository = new LinkRepository();
        $this->pageRepository = new PageRepository();
        $adapterMock = $this->createMock(\App\Domain\IAdapter::class);
        $parserMock = $this->createMock(\App\Domain\IParser::class);

        $this->pageService = new \App\Infrastructure\PageService(
            $this->linkRepository,
            $this->pageRepository,
            $parserMock,
            $adapterMock
        );
    }

    /** @test */
    public function canCreatePageInstance()
    {
        $page = $this->pageService->createPageObject('test.com', 5, 0.47);

        $this->assertInstanceOf(\App\Domain\Page::class, $page);
        $this->assertEquals($page->getUrl(), 'http://test.com');
        $this->assertEquals($page->getImageCount(), 5);
        $this->assertEquals($page->getLoadingTime(), 0.47);
    }
}