<?php

namespace App\Parser\CommonParser\Command\QuestionParse\Request;

use App\Parser\Entity\Parser\CommonParser\Parser;

class Command
{
    public function __construct(
        public readonly Parser $parser,
    ){}
}
