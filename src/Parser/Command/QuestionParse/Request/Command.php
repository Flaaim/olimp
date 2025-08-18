<?php

namespace App\Parser\Command\QuestionParse\Request;

use App\Parser\Entity\Parser\Parser;

class Command
{
    public function __construct(
        public readonly Parser $parser,
    ){}
}
