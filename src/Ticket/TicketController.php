<?php

namespace App\Ticket;

use App\Http\JsonResponse;
use App\Ticket\Command\Save\Request\Command as SaveCommand;
use App\Ticket\Command\Delete\Request\Command as DeleteCommand;
use App\Ticket\Command\ListTickets\Request\Command as ListTicketsCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Ticket\Command\Save\Request\Handler as SaveHandler;
use App\Ticket\Command\Delete\Request\Handler as DeleteHandler;
use App\Ticket\Command\ListTickets\Request\Handler as ListTicketsHandler;

class TicketController
{
    public function __construct(
        private readonly SaveHandler $saveHandler,
        private readonly DeleteHandler $deleteHandler,
        private readonly ListTicketsHandler $listTicketsHandler,
    )
    {}

    public function add(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        try{
            $result = $this->saveHandler->handle(new SaveCommand($data));
            return new JsonResponse($result, 200);
        }catch (\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function remove(Request $request, Response $response): Response
    {
        $id = $request->getParsedBody()['id'] ?? null;
        try {
            $result = $this->deleteHandler->handle(new DeleteCommand($id));
            return new JsonResponse($result, 200);
        }catch (\DomainException $e){
            return new JsonResponse(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function listTickets(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        try{
            $result = $this->listTicketsHandler->handle(new ListTicketsCommand(
                searchQuery: $params['searchQuery'] ?? null,
                sortBy: $params['sortBy'] ?? 'name',
                sortOrder: $params['sortOrder'] ?? 'asc',
                page: (int)($params['page'] ?? 1),
                perPage: (int)($params['perPage'] ?? 20)
            ));
            return new JsonResponse($result, 200);
        }catch (\DomainException $e){
            return new JsonResponse(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
