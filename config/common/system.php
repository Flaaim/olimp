<?php

declare(strict_types=1);

use App\Parser\Entity\Parser\HostMapper;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

return [
    'config' => [
        'debug' => (bool)getenv('APP_DEBUG'),
        'hosts' => [
            'http://prk.kuzstu.ru:9001/',
            'http://olimpoks.chukk.ru:82/',
            'http://olimpoks5.krsk.irgups.ru/',
            'http://cpkchita.ru:9001/'
        ]
    ],
    ResponseFactoryInterface::class => Di\get(ResponseFactory::class),

    HostMapper::class => function (ContainerInterface $container) {
        return new HostMapper($container->get('config')['hosts']);
    }
];
