<?php

declare(strict_types=1);

use App\Console\FixturesLoadCommand;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Psr\Container\ContainerInterface;

return [
    FixturesLoadCommand::class => function (ContainerInterface $container) {
        $config = $container->get('config')['console'];

        $em = $container->get(EntityManagerInterface::class);

        return new FixturesLoadCommand(
          $em,
          $config['fixture_paths'],
        );
    },
    'config' => [
        'console' => [
            'commands' => [
                FixturesLoadCommand::class,

                DropCommand::class,

                DiffCommand::class,
                GenerateCommand::class,
            ],
            'fixture_paths' => [
                __DIR__ . '/../../src/Parser/Fixture',
            ],
        ],
    ]
];
