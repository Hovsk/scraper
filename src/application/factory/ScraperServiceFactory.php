<?php

namespace App\Application\Factory;

use App\Application\IScraperInterface;
use App\Application\ScraperService;
use App\Infrastructure\Factory\PageServiceFactory;
use App\Infrastructure\LinkRepository;
use App\Infrastructure\PageRepository;
use App\Infrastructure\ReportGeneratorService;

abstract class ScraperServiceFactory implements IScraperInterface
{
    public static function create() : ScraperService
    {
        $linkRepo = new LinkRepository();
        $pageRepo = new PageRepository();

        return new ScraperService(
            $linkRepo,
            $pageRepo,
            PageServiceFactory::create($linkRepo, $pageRepo),
            new ReportGeneratorService($pageRepo)
        );
    }
}