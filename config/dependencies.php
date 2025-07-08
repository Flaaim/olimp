<?php

declare(strict_types=1);


use Dotenv\Dotenv;

$app_env = getenv('APP_ENV');
$file = ($app_env === 'dev') ? "dev.env" : ".env";
if (file_exists(__DIR__ . '/common/env/' . $file)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/common/env/', $file);
    $dotenv->load();
} else {
    exit(".Env file not found");
}

$files = glob(__DIR__ . '/common/*.php');


$configs = array_map(
    static function ($file){
        return require $file;
    },
    $files
);

return array_merge_recursive(...$configs);
