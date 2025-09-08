<?php

declare(strict_types=1);

use App\Parser\Entity\Parser\HostMapper;
use App\Ticket\Service\ImageDownloader\PathBuilder;
use App\Ticket\Service\ImageDownloader\UrlBuilder;
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
        ],
        'basePath' => __DIR__ . '/../../public/QuestionImages',
        'urlPath' => 'http://localhost/QuestionImages',
    ],
    ResponseFactoryInterface::class => Di\get(ResponseFactory::class),

    HostMapper::class => function (ContainerInterface $container) {
        return new HostMapper($container->get('config')['hosts']);
    },
    PathBuilder::class => function (ContainerInterface $container) {
        return new PathBuilder($container->get('config')['basePath']);
    },
    UrlBuilder::class => function (ContainerInterface $container) {
        return new UrlBuilder($container->get('config')['basePath']);
    }
];
