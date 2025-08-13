<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Host;
use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    public function testSuccess(): void
    {

        $host = new Host($value = Host::HOST_CHUKK);
        $this->assertNotNull($host->getValue());
        $this->assertSame($value, $host->getValue());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Host('invalid');
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Host('');
    }
}
