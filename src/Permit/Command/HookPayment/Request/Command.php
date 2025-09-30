<?php

namespace App\Permit\Command\HookPayment\Request;

class Command
{
    public function __construct(
        public readonly string $requestBody
    ){}
}
