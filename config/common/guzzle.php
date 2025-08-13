<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Container\ContainerInterface;

return [
  ClientInterface::class => function (ContainerInterface $container) {
    return new Client();
  }
];
