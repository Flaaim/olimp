<?php

namespace App\Http\Test\Middleware;

use App\Http\Middleware\ClearInputMiddleware;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;


class ClearInputMiddlewareTest extends TestCase
{
    public function testClearInput(): void
    {
        $data = [
            'foo' => 'bar',
            'baz' => ' qux ',
            'one' => null,
            'test' => [
                'foo' => '    ',
            ]
        ];
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/test');
        $request = $request->withParsedBody($data);

        $middleware = new ClearInputMiddleware();
        $handler = $this->createMock(RequestHandlerInterface::class);

        $handler->expects($this->once())->method('handle')
            ->willReturnCallback(static function (ServerRequestInterface $request): ResponseInterface {
            self::assertEquals([
                'foo' => 'bar',
                'baz' => 'qux',
                'one' => null,
                'test' => [
                    'foo' => '',
                ]
            ], $request->getParsedBody());
            return (new ResponseFactory())->createResponse();
        });

        $middleware->process($request, $handler);
    }

}
