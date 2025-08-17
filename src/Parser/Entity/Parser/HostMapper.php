<?php

namespace App\Parser\Entity\Parser;

use Webmozart\Assert\Assert;

class HostMapper
{
    private array $value;
    public function __construct(array $hosts)
    {
        Assert::notEmpty($hosts);
        $this->value = $hosts;
    }

    public function getValue(): array
    {
        return $this->value;
    }
}
