<?php

namespace App\Parser\Command;

class ParserCommand
{
    public function __construct(
        public readonly string $host,
        public readonly string $branchId,
        public readonly string $ticketId,
        public readonly string $cookie,
        public readonly array $options = [],
    ){}
}
