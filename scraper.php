<?php

use App\Exceptions\InvalidSapiException;

const BASE_DIR = __DIR__ . DIRECTORY_SEPARATOR;

require_once __DIR__ . "/vendor/autoload.php";

if (php_sapi_name() !== 'cli') {
    throw new InvalidSapiException("please run this script through CLI SAPI");
}

$handle = fopen ("php://stdin","r");

echo "Please provide site URL: ";
$url = trim(fgets($handle));
if (empty($url)) {
    echo "\nI can't work without site URL!!!\n\n";
    exit;
}

echo "And the limit of pages also (Default is 20): ";

$limit = trim(fgets($handle));
$limit =  $limit > 0 ? (int)$limit : 20;
fclose($handle);

$app = \App\Application\Factory\ApplicationFactory::create();
$app->process($url, $limit);

echo "\n";
echo "Thank you. Bye...\n";


