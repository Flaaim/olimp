<?php

declare(strict_types=1);


use App\Http\Action\HomeAction;

use App\Ticket\TicketController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', HomeAction::class);

    $app->group('/v1', function (RouteCollectorProxy $group) {
        $group->group('/parser', function (RouteCollectorProxy $group) {
            $group->post('/parse', \App\Http\Action\V1\Parser\Parse\RequestAction::class);
            $group->post('/gpnparse', \App\Http\Action\V1\Parser\GpnParser\RequestAction::class);

        });

        $group->group('/tickets', function (RouteCollectorProxy $group) {
            $group->post('/add', [TicketController::class, 'add']);
            $group->post('/remove', [TicketController::class, 'remove']);
            $group->post('/list', [TicketController::class, 'listTickets']);
        });
    });
};
