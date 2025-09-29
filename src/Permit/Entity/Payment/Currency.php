<?php

namespace App\Permit\Entity\Payment;

use Webmozart\Assert\Assert;

class Currency
{
    public const VALUES = ['RUB', 'USD', 'EUR'];
    private string $value;
    public function __construct(string $value)
    {
        Assert::oneOf($value, self::VALUES);
        $this->value = mb_strtoupper($value);
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
