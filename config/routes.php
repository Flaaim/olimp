<?php

declare(strict_types=1);

use App\Parser\ParserController;
use App\Ticket\TicketController;
use Slim\App;

return static function (App $app): void {
    $app->get('/', \App\Http\Action\HomeAction::class);

    $app->post('/api/parser/parse', [ParserController::class, 'parse']);

    $app->post('/api/ticket/add', [TicketController::class, 'add']);

    $app->post('/api/ticket/remove', [TicketController::class, 'remove']);
};
