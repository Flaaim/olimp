<?php

namespace App\Permit\Test\Entity\Access;

use App\Permit\Entity\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $email = new Email($value = 'email@test.ru');
        $this->assertSame($value, $email->getValue());
    }
    public function testCase(): void
    {
        $value = 'email@test.ru';
        $email = new Email(mb_strtoupper($value));
        $this->assertSame($value, $email->getValue());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('invalid');
    }

    public function testEmptyValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('');
    }
}
