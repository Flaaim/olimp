<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

return [
    Twig::class => function (ContainerInterface $container) {
        $loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates');
        return new Twig($loader, [
            'debug' => true,
        ]);
    }
];
