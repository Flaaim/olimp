<?php

namespace App\Parser\Entity\Ticket;

use Webmozart\Assert\Assert;

final class Status
{
    public const STATUSES = [
        'active',
        'archived',
        'nonactive',
    ];
    private string $value;
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
    public static function archived(): self
    {
        return new self('archived');
    }
    public static function nonactive(): self
    {
        return new self('nonactive');
    }
}
