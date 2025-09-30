<?php

namespace App\Permit\Entity\Access;

use Webmozart\Assert\Assert;

class Status
{
    public const STATUSES = [
        'active',
        'used'
    ];

    public string $value;
    public function __construct(string $value)
    {
        Assert::oneOf($value, self::STATUSES);
        $this->value = $value;
    }
    public function getValue(): string
    {
        return $this->value;
    }
    public static function active(): self
    {
        return new self('active');
    }
    public static function used(): self
    {
        return new self('used');
    }
}
