<?php

namespace App\Permit\Entity\Payment;

use Webmozart\Assert\Assert;

class Price
{
    const DEFAULT = 150.00;
    public function __construct(private float $value, private readonly Currency $currency){
        Assert::greaterThan($this->value, 0);
        $this->value = round($value, 2);
    }

    public static function default(): self
    {
        return new self(self::DEFAULT, new Currency('RUB'));
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
    public function formatted(): string
    {
        return number_format($this->value, 2, '.', ' ') . ' ' . $this->currency->getValue();
    }

    public function equals(Price $price): bool
    {
        return $this->value === $price->getValue()
            && $this->currency === $price->getCurrency();
    }
}
