<?php

namespace App\Http\Action\V1\Parser\GpnParser;


use App\Parser\GpnParser\Command\ParserCommand;
use App\Parser\GpnParser\Command\ParserHandler;
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
        try{
            $data = $request->getParsedBody() ?? [];
            if(empty($data)) {
                throw new RuntimeException('Request data is empty');
            }
            $command = new ParserCommand(
                $data['materialId'] ?? '',
                $data['host'] ?? '',
                $data['questionIds'] ?? '',
                $data['topicId'] ?? '',
                $data['cookie'] ?? '',
                    $data['options'] ?? []
            );
            $handler = $this->container->get(ParserHandler::class);
            /** @var $handler ParserHandler */

            $ticket = $handler->handle($command);

            $serializeType = $data['options']['type'] ?? 'html';

            $factory = new TicketResponseFactory($serializeType, $this->twig);

            return $factory->createResponse($ticket);

        }catch(RuntimeException){
            throw new RuntimeException('Request data is empty');
        }

    }
}
