<?php

namespace App\Permit\Command\CreatePayment\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $ticketId,
        public readonly string $email
    ){
        Assert::uuid($this->ticketId);
        Assert::email($this->email);
    }
}
