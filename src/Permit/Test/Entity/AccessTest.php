<?php

namespace App\Permit\Test\Entity;

use App\Permit\Entity\Access;
use App\Permit\Entity\Email;
use App\Permit\Entity\Status;
use App\Permit\Entity\Token;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AccessTest extends TestCase
{
    public function testSuccess(): void
    {
        $access = new Access(
          $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable('+ 1 day')),
          $email = new Email('some@app.ru'),
          $ticketId = 'ticketId',
          $paymentId = 'paymentId',
          $status = new Status(),
          $created = new DateTimeImmutable()
        );

        $this->assertEquals($token, $access->getToken());
        $this->assertEquals($email, $access->getEmail());
        $this->assertEquals($ticketId, $access->getTicketId());
        $this->assertEquals($paymentId, $access->getPaymentId());
        $this->assertEquals($status, $access->getStatus());
        $this->assertEquals($created, $access->getCreated());

    }
}
