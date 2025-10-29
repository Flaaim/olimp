<?php

namespace App\Http\Action\V1\Parser\Parse;

use App\Http\HtmlResponse;
use App\Http\JsonResponse;
use App\Parser\Command\ParserCommand;
use App\Parser\Command\ParserHandler;
use App\Shared\Domain\Response\HtmlTicketSerializer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

class RequestAction implements RequestHandlerInterface
{
    public function __construct(private readonly ContainerInterface $container)
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
            $response = $handler->handle($command);

            if(isset($data['options']['serialize']) && $data['options']['serialize'] === 'html') {
                $data = (new HtmlTicketSerializer())->serialize($response);
                return new HtmlResponse($data);
            }

            return new JsonResponse($response);
        }catch (\Exception $e){
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }
}
