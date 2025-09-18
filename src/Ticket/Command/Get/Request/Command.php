<?php

namespace App\Ticket\Command\Get\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(public readonly string $ticketId)
    {
        Assert::notEmpty($ticketId);
    }
}
