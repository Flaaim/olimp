<?php

namespace App\Permit\Test\Entity\Payment;

use App\Permit\Entity\Email;
use App\Permit\Entity\Payment\Currency;
use App\Permit\Entity\Payment\Price;
use App\Permit\Entity\Payment\Status;
use App\Permit\Test\Builder\PaymentBuilder;
use App\Shared\Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PaymentTest extends TestCase
{
    public function testSuccess(): void
    {
        $payment = (new PaymentBuilder())
            ->withId($id = new Id(Uuid::uuid4()->toString()))
            ->withEmail($email = new Email('user@app.ru'))
            ->withPrice($price = new Price(150.00, new Currency('RUB')))
            ->withTicketId($ticketId = 'ticketId')
            ->build();

        $this->assertEquals($id, $payment->getId()->getValue());
        $this->assertEquals($email->getValue(), $payment->getEmail()->getValue());
        $this->assertEquals($price->getValue(), $payment->getPrice()->getValue());
        $this->assertEquals('pending', $payment->getStatus()->getValue());
        $this->assertEquals($ticketId, $payment->getTicketId());

    }

    public function testSetExternalId(): void
    {
        $payment = (new PaymentBuilder())
            ->withExternalId($id = new Id(Uuid::uuid4()->toString()))
            ->build();


        $this->assertEquals($id, $payment->getExternalId());
    }

    public function testUpdatePaymentStatus(): void
    {
        $payment = (new PaymentBuilder())->build();
        $payment->setStatus(Status::failed());
        $this->assertEquals('failed', $payment->getStatus()->getValue());
    }
}
