<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Parser\Host;
use App\Parser\Entity\Parser\HostMapper;
use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    private array $hosts;
    public function testSuccess(): void
    {

        $host = new Host($value = 'http://olimpoks.chukk.ru:82/', $this->getHostMapper());
        $this->assertNotNull($host->getValue());
        $this->assertSame($value, $host->getValue());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Host('invalid', $this->getHostMapper());
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Host('', $this->getHostMapper());
    }

    public function testFullPath(): void
    {
        $host = new Host($value = 'http://olimpoks.chukk.ru:82/', $this->getHostMapper());
        $fullPath = 'http://olimpoks.chukk.ru:82/Admin/Info/GetTicketInfo/';

        $this->assertSame($fullPath, $host->getFullPathToCourse());

    }

    private function getHostMapper(): HostMapper
    {
        $hosts = [
            'http://prk.kuzstu.ru:9001/',
            'http://olimpoks.chukk.ru:82/'
        ];
        return new HostMapper($hosts);
    }
}
