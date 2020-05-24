<?php

namespace App\Infrastructure;

use App\Domain\IAdapter;
use App\Exceptions\InvalidConnectionException;

class CurlAdapter implements IAdapter
{
    private static array $options = [
        'return_transfer' => true,
        'connect_timeout' => 30,
        'timeout' => 60,
        'follow_location' => true
    ];

    /**
     * @throws InvalidConnectionException
     */
    public function load(string $url) : string
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, self::$options['return_transfer']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$options['connect_timeout']);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$options['timeout']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, self::$options['follow_location']);

        $content = curl_exec($ch);

        if (empty($content)) {
            throw new InvalidConnectionException("Invalid Connection!");
        }

        return $content;
    }
}