<?php

namespace App\Parser\GpnParser\Command;

class ParserCommand
{
    public function __construct(
        public readonly string $materialId,
        public readonly string $host,
        public readonly string $questionIds,
        public readonly string $topicId,
        public readonly string $cookie,
        public readonly array $options = []
    )
    {}

}
