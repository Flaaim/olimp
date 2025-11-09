<?php

namespace App\Parser\CommonParser\Command\Process\Request;

use App\Parser\Entity\Parser\Options;

class Command
{
    public function __construct(
        public array   $rawData,
        public readonly Options $options
    )
    {}
}
