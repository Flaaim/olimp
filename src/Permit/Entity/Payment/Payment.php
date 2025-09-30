<?php

namespace App\Permit\Entity\Payment;

use App\Permit\Entity\Email;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
#[ORM\Table(name: 'payments')]
class Payment
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $externalId = null;
    #[ORM\Column(type: 'price')]
    private Price $price;
    #[ORM\Column(type: 'email')]
    private Email $email;
    #[ORM\Column(type:'payment_status')]
    private Status $status;
    #[ORM\Column(type:'string', length: 255)]
    private string $ticketId;
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;
    public function __construct(Id $id, Email $email, Price $amount, Status $status, string $ticketId, DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->email = $email;
        $this->price = $amount;
        $this->status = $status;
        $this->ticketId = $ticketId;
        $this->createdAt = $createdAt;
    }

    public function getId(): Id
    {
        return $this->id;
    }
    public function getEmail(): Email
    {
        return $this->email;
    }
    public function getPrice(): Price
    {
        return $this->price;
    }
    public function getStatus(): Status
    {
        return $this->status;
    }
    public function getTicketId(): string
    {
        return $this->ticketId;
    }
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }
    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }
    public function setStatus(Status $status): void
    {
        if($status->getValue() === $this->status->getValue()){
            throw new \DomainException("Payment status is already set");
        }
        $this->status = $status;
    }
}
