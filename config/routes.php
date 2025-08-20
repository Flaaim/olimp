<?php

declare(strict_types=1);


use App\Http\Index\IndexController;
use App\Parser\ParserController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', [IndexController::class, 'index']);


    $app->post('/api/parse', [ParserController::class, 'parse']);

    $app->group('/parser', function (RouteCollectorProxy $group) {
        $group->get('/results', [ParserController::class, 'showResults']);
    });
};
