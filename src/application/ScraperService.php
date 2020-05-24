<?php

namespace App\Application;

use App\Domain\ILinkRepository;
use App\Domain\IPageRepository;
use App\Domain\IPageService;
use App\Infrastructure\ReportGeneratorService;

class ScraperService implements IScraperInterface
{
    private IPageService $pageService;
    private ILinkRepository $linkRepository;
    private IPageRepository $pageRepository;
    private ReportGeneratorService $reportGeneratorService;

    public function __construct(
        ILinkRepository $linkRepository,
        IPageRepository $pageRepository,
        IPageService $pageService,
        ReportGeneratorService $reportGeneratorService
    ) {
        $this->pageService = $pageService;
        $this->pageRepository = $pageRepository;
        $this->linkRepository = $linkRepository;
        $this->reportGeneratorService = $reportGeneratorService;
    }

    public function run(string $mainUrl, int $limit = 25) : void
    {
        $page = $mainUrl;
        for ($i = 0; $i < $limit; $i++) {
            $this->pageService->parsePage($page);
            if ($this->linkRepository->isLinkStackEmpty()) {
                break;
            }
            $page = $this->linkRepository->getNextUrl();
        }

        $this->pageRepository->sort();
        $this->reportGeneratorService->generate();
    }

}