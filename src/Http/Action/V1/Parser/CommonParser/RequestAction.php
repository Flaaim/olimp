<?php

namespace App\Http\Action\V1\Parser\CommonParser;

use App\Http\JsonResponse;
use App\Parser\CommonParser\Command\ParserCommand;
use App\Parser\CommonParser\Command\ParserHandler;
use App\Shared\Domain\Response\TicketResponseFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use Twig\Environment;

class RequestAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly Environment $twig)
    {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody() ?? [];
        try {
            if(empty($data)) {
                throw new RuntimeException('Request data is empty');
            }
            $command = new ParserCommand(
                $data['host'] ?? '',
                $data['branchId'] ?? '',
                $data['ticketId'] ?? '',
                $data['cookie'] ?? '',
                $data['options'] ?? []
            );
            $handler = $this->container->get(ParserHandler::class);
            /** @var ParserHandler $handler */

            $ticket = $handler->handle($command);

            $serializeType = $data['options']['type'] ?? 'json';

            $factory = new TicketResponseFactory($serializeType, $this->twig);

            return $factory->createResponse($ticket);
        }catch (\Exception $e){
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }
}
