<?php

declare(strict_types=1);


use App\Http\Action\HomeAction;
use App\Ticket\TicketController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\Parser\Parse;

return static function (App $app): void {
    $app->get('/', HomeAction::class);
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->group('/parser', function (RouteCollectorProxy $group) {
            $group->post('/parse', Parse\RequestAction::class);

        });
    });

    $app->post('/api/ticket/add', [TicketController::class, 'add']);

    $app->post('/api/ticket/remove', [TicketController::class, 'remove']);

    $app->get('/api/ticket/list', [TicketController::class, 'listTickets']);
};
