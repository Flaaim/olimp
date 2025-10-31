<?php

declare(strict_types=1);

return [
    'config' => [
        'logger' => [
            'stderr' => false,
            'file' => __DIR__ . '/../../var/log/' . PHP_SAPI . '/development.log',
        ]
    ]
];
