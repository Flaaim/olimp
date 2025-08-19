<?php

declare(strict_types=1);


use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (App $app, ContainerInterface $container): void {

    $app->addMiddleware(TwigMiddleware::create($app, $container->get(Twig::class)));

    $app->addErrorMiddleware($container->get('config')['debug'], true, true);
};
