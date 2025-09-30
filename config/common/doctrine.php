<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerInterface;

return [
    EntityManagerInterface::class => function (ContainerInterface $container) {
        $settings = $container->get('config')['doctrine'];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            null
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }

        $connection = DriverManager::getConnection(
            $settings['connection'],
            $config
        );

        return new EntityManager($connection, $config);
    },
    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' =>  __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../../var/cache/doctrine/proxy',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => getenv('DB_HOST'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'dbname' => getenv('DB_NAME'),
                'charset' => 'utf-8'
            ],
            'metadata_dirs' => [
                __DIR__ . '/../../src/Parser/Entity/Ticket',
                __DIR__ . '/../../src/Permit/Entity/Payment',
                __DIR__ . '/../../src/Permit/Entity/Access',
            ],
            'types' => [
                App\Shared\Domain\ValueObject\IdType::NAME => App\Shared\Domain\ValueObject\IdType::class,
                App\Parser\Entity\Ticket\TicketStatusType::NAME => App\Parser\Entity\Ticket\TicketStatusType::class,

                App\Permit\Entity\Payment\PaymentStatusType::NAME => App\Permit\Entity\Payment\PaymentStatusType::class,
                App\Permit\Entity\Access\AccessStatusType::NAME => App\Permit\Entity\Access\AccessStatusType::class,

                App\Permit\Entity\Payment\PriceType::NAME => App\Permit\Entity\Payment\PriceType::class,
                App\Permit\Entity\EmailType::NAME => App\Permit\Entity\EmailType::class,
            ],
        ]
    ],
    EntityManagerProvider::class => function (ContainerInterface $container): SingleManagerProvider {
        return new SingleManagerProvider($container->get(EntityManagerInterface::class));
    },
];
