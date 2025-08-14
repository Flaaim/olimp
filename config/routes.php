<?php

declare(strict_types=1);


use App\Http\Action\HomeAction;
use App\Parser\ParserController;
use Slim\App;

return static function (App $app): void {
    $app->get('/', HomeAction::class);
    $app->post('/api/parse', [ParserController::class, 'parse']);
};
