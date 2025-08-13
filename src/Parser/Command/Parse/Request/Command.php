<?php

namespace App\Parser\Command\Parse\Request;

use App\Parser\Entity\Parser;

class Command
{
    public function __construct(
        public readonly Parser $parser,
    ){}
}
