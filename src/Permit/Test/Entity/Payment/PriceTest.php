<?php

namespace App\Permit\Test\Entity\Payment;

use App\Permit\Entity\Payment\Currency;
use App\Permit\Entity\Payment\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testSuccess(): void
    {
        $price = new Price($value  = 150.00, $this->getCurrency());
        $this->assertEquals($value, $price->getValue());
    }
    public function testInvalidCurrency(): void
    {
        $this->expectException('InvalidArgumentException');
        new Price(-150.00, $this->getCurrency());
    }
    public function testRoundValue(): void
    {
        $price = new Price($value = 150.00000, $this->getCurrency());
        $this->assertEquals(150.00, $price->getValue());
    }
    private function getCurrency(): Currency
    {
        return new Currency('RUB');
    }
}
