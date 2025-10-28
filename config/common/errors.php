<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Middleware\ErrorMiddleware;

return [
  ErrorMiddleware::class => function (ContainerInterface $container) {

    $responseFactory = $container->get(ResponseFactoryInterface::class);
    $callableResolver = $container->get(CallableResolverInterface::class);

    $config = $container->get('config')['errors'];

      return new ErrorMiddleware(
          $callableResolver,
          $responseFactory,
          $config['displayErrors'],
          true,
          true
      );

  },
    'config' => [
        'errors' => [
            'displayErrors' => (bool)getenv('APP_DEBUG'),
            'log' => true,
        ]
    ]
];
