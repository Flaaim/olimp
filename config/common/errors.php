<?php

declare(strict_types=1);

use App\ErrorHandler\LogErrorHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Middleware\ErrorMiddleware;

return [
  ErrorMiddleware::class => function (ContainerInterface $container) {

    $responseFactory = $container->get(ResponseFactoryInterface::class);
    $callableResolver = $container->get(CallableResolverInterface::class);

    $config = $container->get('config')['errors'];

    $middleware = new ErrorMiddleware(
      $callableResolver,
      $responseFactory,
      $config['displayErrors'],
      true,
      true,
    );
    $logger = $container->get(LoggerInterface::class);

    $middleware->setDefaultErrorHandler(
      new LogErrorHandler(
          $callableResolver,
          $responseFactory,
          $logger
      )
    );

    return $middleware;
  },
    'config' => [
        'errors' => [
            'displayErrors' => (bool)getenv('APP_DEBUG'),
            'log' => true,
        ]
    ]
];
