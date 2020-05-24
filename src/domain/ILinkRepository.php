<?php

namespace App\Domain;

interface ILinkRepository
{
    public function add(Link $Link): void ;
    public function getNextUrl() : string ;
    public function isLinkStackEmpty() : bool ;
    public function getAll() : array ;
}