<?php

namespace App\Application;

interface IScraperInterface
{
    public function run(string $mainUrl, int $limit);
}