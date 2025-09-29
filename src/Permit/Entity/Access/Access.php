<?php

namespace App\Permit\Entity\Access;

use App\Permit\Entity\Email;
use App\Permit\Entity\Token;
use DateTimeImmutable;

class Access
{
    private Token $token;
    private Email $email;
    private string $ticketId;
    private string $paymentId;
    private Status $status;
    private DateTimeImmutable $created;

    public function __construct(Token $token, Email $email, string $ticketId, string $paymentId, Status $status, DateTimeImmutable $created)
    {
        $this->token = $token;
        $this->email = $email;
        $this->ticketId = $ticketId;
        $this->paymentId = $paymentId;
        $this->status = $status;
        $this->created = $created;
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

    public function getStatus(): Status
    {
        return $this->status;
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
