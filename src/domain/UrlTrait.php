<?php

namespace App\Domain;

trait UrlTrait
{
    private function purifyUrl(string $url): string
    {
        if (!array_key_exists('scheme', parse_url($url))) {
            $url = 'http://' . $url;
        }

        return $url;
    }
}