<?php

namespace App\Domain;

interface IParser
{
    public function getLinkList() : array ;
    public function getImageList() : array ;

}