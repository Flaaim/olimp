<?php

namespace App\Permit\Test\Unit\Entity\Payment;

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

    public function testDefaultPrice(): void
    {
        $price = Price::default();
        $this->assertEquals(150.00, $price->getValue());
    }
    public function testEqualsTrue(): void
    {
        $price = new Price(150.00, $this->getCurrency());
        $this->assertTrue($price->equals($price));
    }

    public function testEqualsFalse(): void
    {
        $price = new Price(150.00, $this->getCurrency());
        $newPrice = new Price(250.00, new Currency('USD'));
        $this->assertFalse($price->equals($newPrice));
    }

    private function getCurrency(): Currency
    {
        return new Currency('RUB');
    }

}
