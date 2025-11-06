<?php

declare(strict_types=1);


use App\Http\Middleware\ClearInputMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $app): void {
    $app->add(ClearInputMiddleware::class);
    $app->add(ErrorMiddleware::class);
    $app->addBodyParsingMiddleware();
};
