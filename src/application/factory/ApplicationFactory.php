<?php

namespace App\Application\Factory;

use App\Application\Application;

abstract class ApplicationFactory
{
    public static function create(): Application
    {
        return new Application(
            ScraperServiceFactory::create()
        );
    }
}