<?php

namespace App\Permit\Test\Entity\Access;

use App\Permit\Entity\Token;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;


class TokenTest extends TestCase
{
    public function testSuccess(): void
    {
        $token = new Token(
            $value = Uuid::uuid4()->toString(),
            $expires = new DateTimeImmutable('+ 1 day')
        );

        $this->assertEquals($value, $token->getValue());
        $this->assertEquals($expires, $token->getExpires());
        $this->assertFalse($token->isUsed());
    }
    public function testCase(): void
    {
        $value = Uuid::uuid4()->toString();
        $token = new Token(
            mb_strtoupper($value),
            new DateTimeImmutable(),
        );
        $this->assertEquals($value, $token->getValue());
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $token = new Token(
            '',
            new DateTimeImmutable(),
        );
    }

    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Token('invalid', new DateTimeImmutable());
    }

    public function testExpired(): void
    {
        $token = new Token(
            UUID::uuid4()->toString(),
            new DateTimeImmutable('+ 1 day'),
        );
        $date = new DateTimeImmutable();

        $this->assertFalse($token->isExpiredTo($date));

        $date = $date->modify('+ 2 day');

        $this->assertTrue($token->isExpiredTo($date));
    }

    public function testValidateValue(): void
    {
        $token = new Token(
            UUID::uuid4()->toString(),
            new DateTimeImmutable(),
        );
        $value = UUID::uuid4()->toString();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Token is invalid.');

        $token->validate($value, new DateTimeImmutable());

    }
    public function testValidateExpired(): void
    {
        $token = new Token(
            $value = Uuid::uuid4()->toString(),
            new DateTimeImmutable('+ 1 day'),
        );
        $date = new DateTimeImmutable('+ 2 day');

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Token is expired.');
        $token->validate($value, $date);
    }

}
