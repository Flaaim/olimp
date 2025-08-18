<?php

namespace App\Parser\Command\AnswerParse\Request;

use App\Parser\Entity\Parser\Parser;

class Command
{
    public function __construct(
        public readonly array  $questions,
        public readonly Parser $parser,
    )
    {}
}
