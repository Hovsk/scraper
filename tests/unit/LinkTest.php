<?php

class LinkTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function internalTestCheckWorks()
    {
        $link = new \App\Domain\Link(
            'https://www.test.com/test/',
            'www.google.com'
        );

        $this->assertFalse(
            $link->isInternal()
        );

        $link = new \App\Domain\Link(
            'https://www.test.com/test/',
            'www.test.com'
        );

        $this->assertTrue(
            $link->isInternal()
        );
    }
}