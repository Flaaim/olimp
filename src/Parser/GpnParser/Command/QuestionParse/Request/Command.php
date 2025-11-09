<?php

namespace App\Parser\GpnParser\Command\QuestionParse\Request;

use App\Parser\Entity\Parser\GpnParser\GpnParser;

class Command
{
    public function __construct(public readonly GpnParser $parser){}
}
