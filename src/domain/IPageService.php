<?php

namespace App\Domain;

interface IPageService
{
    public function parsePage(string $url);
}