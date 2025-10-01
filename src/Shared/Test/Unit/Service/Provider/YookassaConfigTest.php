<?php

namespace App\Shared\Test\Unit\Service\Provider;

use App\Shared\Domain\Service\Payment\Provider\YookassaConfig;
use PHPUnit\Framework\TestCase;

class YookassaConfigTest extends TestCase
{
    public function testSuccess(): void
    {
        $config = $this->getConfig();
        $yookassaConfig = new YookassaConfig(
            $config['name'], $config['shopId'], $config['secretKey'], $config['returnUrl']
        );
        $this->assertEquals('Yookassa', $yookassaConfig->getName());
        $this->assertEquals('221345', $yookassaConfig->getShopId());
        $this->assertEquals('test_0B3flJqsbdKNA2sS2dT0ahs74LtF7fwJq2oVR-8wTCM', $yookassaConfig->getSecretKey());
        $this->assertEquals('http://localhost:8080/payment/success', $yookassaConfig->getReturnUrl());
    }
    public function testEmptyConfig(): void
    {
        $config = $this->getConfig();
        $this->expectException(\InvalidArgumentException::class);
        new YookassaConfig('', '', '', '');
    }
    private function getConfig(): array
    {
        return [
            'name' => 'Yookassa',
            'shopId' => '221345',
            'secretKey' => 'test_0B3flJqsbdKNA2sS2dT0ahs74LtF7fwJq2oVR-8wTCM',
            'returnUrl' => 'http://localhost:8080/payment/success',
        ];
    }
}
