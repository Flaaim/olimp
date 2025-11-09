<?php

namespace App\Ticket\Test\Builder;

use App\Parser\Entity\Ticket\Status;
use App\Parser\Entity\Ticket\Ticket;
use App\Permit\Entity\Payment\Currency;
use App\Permit\Entity\Payment\Price;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class TicketBuilder
{
    private  Id $id;
    private  string $name;
    private  string $cipher;
    private  ?Price $price;
    private  Status $status;
    private Collection $questions;
    private readonly ?DateTimeImmutable $updatedAt;

    public function __construct(
        Id $id,
        string $name = null,
        string $cipher = null,
        DateTimeImmutable $updatedAt = null)
    {
        $this->id = $id;
        $this->cipher = $cipher;
        $this->name = $name;
        $this->status = Status::nonactive();
        $this->updatedAt = $updatedAt;
        $this->questions = new ArrayCollection();
    }

    public function build(): Ticket
    {
        $ticket = new Ticket(
            $this->id,
            $this->cipher,
            $this->name,
            new DateTimeImmutable(),
        );

        if($this->status === Status::active()) {
            $ticket->setActive();
        }

        if($this->price !== null) {
            $ticket->setPrice($this->price);
        }

        return $ticket;
    }
    public function active(): self
    {
        $this->status = Status::active();
        return $this;
    }
    public function withPrice(Price $price): self
    {
        $this->price = $price;
        return $this;
    }
    public function withQuestions(Collection $questions): self
    {
        $this->questions = $questions;
        return $this;
    }

}
