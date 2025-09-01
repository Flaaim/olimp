<?php

namespace App\Ticket;

use App\Http\JsonResponse;
use App\Ticket\Command\Save\Request\Command;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Ticket\Command\Save\Request\Handler as SaveHandler;

class TicketController
{
    public function __construct(private readonly SaveHandler $saveHandler)
    {}

    public function add(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        try{
            $result = $this->saveHandler->handle(new Command($data));
            return new JsonResponse($result, 200);
        }catch (\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
