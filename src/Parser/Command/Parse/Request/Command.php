<?php

namespace App\Parser\Command\Parse\Request;

use App\Parser\Entity\Parser\Parser;

class Command
{
    public function __construct(
        public readonly Parser $parser,
    ){}
}
