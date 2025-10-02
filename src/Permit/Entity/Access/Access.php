<?php

namespace App\Permit\Entity\Access;

use App\Permit\Entity\Email;
use App\Permit\Entity\Token;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'accesses')]
class Access
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    #[ORM\Embedded(class: Token::class)]
    private Token $token;
    #[ORM\Column(type: 'email')]
    private Email $email;
    #[ORM\Column(type: 'string', length: 255)]
    private string $ticketId;
    #[ORM\Column(type: 'string', length: 255)]
    private string $paymentId;
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $created;

    public function __construct(Id $id, Token $token, Email $email, string $ticketId, string $paymentId, DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->token = $token;
        $this->email = $email;
        $this->ticketId = $ticketId;
        $this->paymentId = $paymentId;
        $this->created = $created;
    }
    public function getId(): Id
    {
        return $this->id;
    }
    public function getToken(): Token
    {
        return $this->token;
    }
    public function getEmail(): Email
    {
        return $this->email;
    }
    public function getTicketId(): string
    {
        return $this->ticketId;
    }
    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }
}
