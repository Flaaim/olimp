<?php

namespace App\Parser\Command\Input\Request;

class Command
{
    public function __construct(
      public readonly string $host,
      public readonly string $branchId,
      public readonly string $ticketId,
      public readonly string $cookie,
      public readonly array $options
    ){}
}
