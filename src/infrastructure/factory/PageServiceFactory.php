<?php

namespace App\Infrastructure\Factory;

use App\Domain\ILinkRepository;
use App\Domain\IPageRepository;
use App\Infrastructure\CurlAdapter;
use App\Infrastructure\DomParser;
use App\Infrastructure\PageService;

abstract class PageServiceFactory
{
    public static function create(ILinkRepository $linkRepository, IPageRepository $pageRepository)
    {
        return new PageService($linkRepository, $pageRepository, new DomParser(), new CurlAdapter());
    }
}