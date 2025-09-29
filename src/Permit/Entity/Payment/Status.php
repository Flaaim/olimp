<?php

namespace App\Permit\Entity\Payment;

use App\Shared\Domain\Service\Payment\PaymentStatus;
use Webmozart\Assert\Assert;

class Status
{
    const STATUSES = [
        PaymentStatus::PENDING,
        PaymentStatus::SUCCEEDED,
        PaymentStatus::FAILED,
        PaymentStatus::CANCELED,
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
    public static function pending(): self
    {
        return new self(PaymentStatus::PENDING);
    }
    public static function succeeded(): self
    {
        return new self(PaymentStatus::SUCCEEDED);
    }
    public static function failed(): self
    {
        return new self(PaymentStatus::FAILED);
    }
    public static function cancelled(): self
    {
        return new self(PaymentStatus::CANCELED);
    }

}
