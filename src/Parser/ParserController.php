<?php

namespace App\Parser;

use App\Http\JsonResponse;
use App\Parser\Command\ParserCommand;
use App\Parser\Command\ParserHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ParserController
{
    public function __construct(
        private readonly ParserHandler $parserHandler
    ){}

    public function parse(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        try{
            $command = new ParserCommand(
                $data['host'] ?? '',
                $data['branchId'] ?? '',
                $data['ticketId'] ?? '',
                $data['cookie'] ?? '',
                $data['options'] ?? []
            );

            $result = $this->parserHandler->handle($command);
            return new JsonResponse($result, 200);
        } catch (\InvalidArgumentException $e){
            return new JsonResponse($e->getMessage(), 400);
        } catch (\RuntimeException|\Exception $e){
            return new JsonResponse($e->getMessage(), 500);
        }
    }
}
