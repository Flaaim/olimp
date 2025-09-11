<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Ticket\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $status = new Status($value = 'active');

        $this->assertSame($value, $status->getValue());
    }
    public function testActive(): void
    {
        $this->assertSame('active', Status::active()->getValue());
    }
    public function testArchived(): void
    {
        $this->assertSame('archived', Status::archived()->getValue());
    }
    public function testDeactivated(): void
    {
        $this->assertSame('deactivated', Status::deactivated()->getValue());
    }
    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Status('invalid');
    }
}
