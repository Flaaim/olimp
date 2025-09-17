<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\EnvelopeListener;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Address;

return [
    Mailer::class => function (ContainerInterface $container) {
        $config = $container->get('config');
        $dispatcher = new EventDispatcher();
        $event = new EnvelopeListener(
            new Address(
                $config['mailer']['from']['email'],
                $config['mailer']['from']['name']
            )
        );

        $dispatcher->addSubscriber($event);

        $transport = new EsmtpTransport(
            $config['mailer']['host'],
            $config['mailer']['port'],
            $config['mailer']['encryption'],
            $dispatcher,
        );

        return new Mailer($transport);
    },
    'config' => [
       'mailer' => [
           'host' => getenv('MAILER_HOST'),
           'port' => getenv('MAILER_PORT'),
           'username' => getenv('MAILER_USERNAME'),
           'password' => getenv('MAILER_PASSWORD'),
           'encryption' => getenv('MAILER_ENCRYPTION'),
           'from' => ['email' => getenv('MAILER_FROM'), 'name' => getenv('MAILER_FROM_NAME')],
       ]
    ]
];
