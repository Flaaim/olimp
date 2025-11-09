<?php

namespace App\Parser\GpnParser\Command\CheckQuestion\Request;

use App\Parser\Entity\Parser\GpnParser\GpnParser;

class Command
{
    public function __construct(
        public array $questions,
        public string $materialId,
        public GpnParser $parser,
    ){}
}
