<?php

namespace App\Application;

use App\Exceptions\DomContextMissingException;
use App\Exceptions\InvalidConnectionException;
use App\Exceptions\StackIsEmptyException;

class Application
{
    private IScraperInterface $scraperService;

    public function __construct(IScraperInterface $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function process(string $mainUrl, int $limit = 20): void
    {
        try {
            if (empty($mainUrl)) {
                throw new \InvalidArgumentException("please provide url");
            }
            $this->scraperService->run($mainUrl, $limit);

            echo "\nSuccessfully Finished!\n";
        } catch (StackIsEmptyException | InvalidConnectionException | \InvalidArgumentException | DomContextMissingException $e) {
            echo "\n", $e->getMessage() ."\n\n";
        }  catch (\Throwable $e) {
            echo "\nSorry, Unexpected Error: \n", $e->getMessage() ."\n\n";
        }
    }
}