<?php

namespace App\Permit\Entity;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

class Token
{
    private string $value;
    private DateTimeImmutable $expires;
    private bool $isUsed = false;
    public function __construct(string $value, DateTimeImmutable $expires){
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
        $this->expires = $expires;
    }
    public function getValue(): string
    {
        return $this->value;
    }
    public function getExpires(): DateTimeImmutable
    {
        return $this->expires;
    }
    public function isUsed(): bool
    {
        return $this->isUsed;
    }
    public function validate(string $value, DateTimeImmutable $date): void
    {
        if(!$this->isEqualTo($value)) {
            throw new \DomainException("Token is invalid.");
        }
        if($this->isExpiredTo($date)) {
            throw new \DomainException("Token is expired.");
        }
    }

    public function isEqualTo(string $value): bool
    {
        return $this->value === $value;
    }

    public function isExpiredTo(DateTimeImmutable $date): bool
    {
        return $this->expires <= $date;
    }

}
