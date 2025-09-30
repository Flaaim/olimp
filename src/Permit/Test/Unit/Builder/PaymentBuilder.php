<?php

namespace App\Permit\Test\Unit\Builder;

use App\Permit\Entity\Email;
use App\Permit\Entity\Payment\Currency;
use App\Permit\Entity\Payment\Payment;
use App\Permit\Entity\Payment\Price;
use App\Permit\Entity\Payment\Status;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class PaymentBuilder
{
    private Id $id;
    private ?string $externalId = null;
    private Price $price;
    private Email $email;
    private Status $status;
    private string $ticketId;
    private DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id = new Id(Uuid::uuid4()->toString());
        $this->email = new Email('user@app.ru');
        $this->price = new Price(150.00, new Currency('RUB'));
        $this->status = Status::pending();
        $this->ticketId = Uuid::uuid4()->toString();
        $this->createdAt = new DateTimeImmutable();
    }

    public function withId(Id $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function withExternalId(string $externalId): self
    {
        $this->externalId = $externalId;
        return $this;
    }
    public function withPrice(Price $price): self
    {
        $this->price = $price;
        return $this;
    }
    public function withTicketId(string $ticketId): self
    {
        $this->ticketId = $ticketId;
        return $this;
    }
    public function withCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    public function withEmail(Email $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function withStatusFailed(): self
    {
        $this->status = Status::failed();
        return $this;
    }
    public function withStatusSucceeded(): self
    {
        $this->status = Status::succeeded();
        return $this;
    }
    public function build(): Payment
    {
        $payment = new Payment(
            $this->id,
            $this->email,
            $this->price,
            $this->status,
            $this->ticketId,
            $this->createdAt,
        );

        if($this->externalId !== null){
            $payment->setExternalId($this->externalId);
        }

        return $payment;
    }
    public static function completePayment(): Payment
    {
        $builder = new PaymentBuilder();

        $builder->withStatusSucceeded();

        return $builder->build();
    }
}
