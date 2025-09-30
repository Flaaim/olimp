<?php

namespace App\Permit\Test\Unit\Entity\Access;

use App\Permit\Entity\Access\Access;
use App\Permit\Entity\Access\Status;
use App\Permit\Entity\Email;
use App\Permit\Entity\Token;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AccessTest extends TestCase
{
    public function testSuccess(): void
    {
        $access = new Access(
            $id = new Id(Uuid::uuid4()->toString()),
            $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable('+ 1 day')),
            $email = new Email('user@some.ru'),
            $ticketId = 'ticketId',
            $paymentId = 'paymentId',
            $status = Status::active(),
            $created = new DateTimeImmutable()
        );

        $this->assertEquals($id->getValue(), $access->getId()->getValue());
        $this->assertEquals($token, $access->getToken());
        $this->assertEquals($email, $access->getEmail());
        $this->assertEquals($ticketId, $access->getTicketId());
        $this->assertEquals($paymentId, $access->getPaymentId());
        $this->assertEquals($status, $access->getStatus());
        $this->assertEquals($created, $access->getCreated());

    }
}
