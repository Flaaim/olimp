<?php

namespace Test\Functional;


use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;


class WebTestCase extends TestCase
{
    public static function json(string $method, string $path, array $body = []): ServerRequestInterface
    {
        $response = self::request($method, $path)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(json_encode($body, JSON_THROW_ON_ERROR));

        return $response;
    }

    public function app(): App
    {
        return (require __DIR__ . '/../../config/app.php')($this->container());
    }
    public static function request(string $method, string $uri): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $uri);
    }
    private function container(): ContainerInterface
    {
        return require __DIR__ . '/../../config/container.php';
    }

}
