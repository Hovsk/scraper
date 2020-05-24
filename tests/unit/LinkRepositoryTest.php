<?php

use \App\Infrastructure\LinkRepository;

class LinkRepositoryTest extends \PHPUnit\Framework\TestCase
{
    private LinkRepository $linkRepository;

    protected function setUp() : void
    {
        $this->linkRepository = new LinkRepository();
    }

    /** @test */
    public function canAddNewLink()
    {
       $link = new \App\Domain\Link('test.com/test', 'test.com');
       $this->linkRepository->add($link);

       $this->assertNotEmpty($this->linkRepository->getAll());
    }

    /** @test */
    public function nextUrlReturnExceptionWhenStackIsEmpty()
    {
       $this->expectException(\App\Exceptions\StackIsEmptyException::class);
       $this->linkRepository->getNextUrl();
    }

    /** @test */
    public function nextUrlReturnAddedLink()
    {
        $link = new \App\Domain\Link('/test', 'http://test.com');
        $this->linkRepository->add($link);

        $src = $this->linkRepository->getNextUrl();
        $this->assertEquals($src, 'http://test.com/test');
    }
}