<?php

namespace App\Permit\Command\GetAccess\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $ticketId,
        public readonly string $token
    )
    {
        Assert::uuid($this->ticketId);
        Assert::uuid($this->token);
    }
}
