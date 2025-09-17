<?php

namespace App\Permit\Entity;

use Webmozart\Assert\Assert;

class Email
{
    private string $email;

    public function __construct(string $value)
    {
        Assert::email($value);
        $this->email = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
