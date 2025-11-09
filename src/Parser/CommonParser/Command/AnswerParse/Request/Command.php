<?php

namespace App\Parser\CommonParser\Command\AnswerParse\Request;

use App\Parser\Entity\Parser\CommonParser\Parser;

class Command
{
    public function __construct(
        public readonly array  $questions,
        public readonly Parser $parser,
    )
    {}
}
