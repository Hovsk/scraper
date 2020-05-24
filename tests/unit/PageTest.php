<?php

class PageTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function aUrlSetProperly()
    {
        $page = new \App\Domain\Page(
            'test.com'
        );

        $this->assertEquals(
            $page->getUrl(),
            "http://test.com"
        );

        $page = new \App\Domain\Page(
            'https://test.com'
        );

        $this->assertEquals(
            $page->getUrl(),
            "https://test.com"
        );
    }
}