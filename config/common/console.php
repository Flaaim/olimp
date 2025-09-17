<?php

declare(strict_types=1);

use App\Console\MailerCheckCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;

return [
    'config' => [
        'console' => [
            'commands' => [
                ValidateSchemaCommand::class,
                MailerCheckCommand::class,

                ExecuteCommand::class,
                MigrateCommand::class,
                LatestCommand::class,
                StatusCommand::class,
                UpToDateCommand::class,
            ]
        ]
    ]
];
