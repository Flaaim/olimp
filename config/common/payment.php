<?php

declare(strict_types=1);


use App\Shared\Domain\Service\Payment\Provider\YookassaProvider;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use YooKassa\Client;

return [
  YookassaProvider::class => function (ContainerInterface $container) {
        $config = $container->get('config')['payment'];

        $client = new Client();

        $client->setLogger($container->get(LoggerInterface::class));
        $client->setAuth($config['shopId'], $config['secretKey']);

        return new YookassaProvider($client, $config['return_url']);
  },
    'config' => [
        'payment' => [
            'shopId' => '221345',
            'secretKey' => 'test_0B3flJqsbdKNA2sS2dT0ahs74LtF7fwJq2oVR-8wTCM',
            'returnUrl' => 'http://localhost:8080/payment/success',
        ]
    ]
];
