<?php

namespace App\Ticket;

use App\Http\JsonResponse;
use App\Ticket\Command\Save\Request\Command as SaveCommand;
use App\Ticket\Command\Delete\Request\Command as DeleteCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Ticket\Command\Save\Request\Handler as SaveHandler;
use App\Ticket\Command\Delete\Request\Handler as DeleteHandler;

class TicketController
{
    public function __construct(
        private readonly SaveHandler $saveHandler,
        private readonly DeleteHandler $deleteHandler,
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
}
