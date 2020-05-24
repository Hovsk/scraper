<?php

namespace App\Domain;

interface IAdapter
{
    public function load(string $url) : string ;
}