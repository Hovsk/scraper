<?php

namespace App\Domain;

interface IPageRepository
{
    public function addPage(Page $page);
    public function sort();
}