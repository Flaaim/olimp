<?php

namespace App\Permit\Command\CreateAccess\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $ticketId,
        public readonly string $email
    )
    {
        Assert::uuid($this->paymentId);
        Assert::uuid($this->ticketId);
        Assert::email($this->email);
    }
}
