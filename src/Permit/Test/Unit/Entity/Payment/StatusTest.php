<?php

namespace App\Permit\Test\Unit\Entity\Payment;

use App\Permit\Entity\Payment\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $status = new Status($value = 'pending');
        $this->assertEquals('pending', $status->getValue());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Status('invalid');
    }
    public function testEmptyValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Status('');
    }


}
