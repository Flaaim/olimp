<?php

namespace App\Parser\Test\Unit\Builder;

use App\Parser\Entity\Ticket\Ticket;
use Doctrine\Common\Collections\ArrayCollection;

class TicketBuilder
{

    public function __construct()
    {

    }

    public function build(array $ticketData): Ticket
    {
        return new Ticket(
            Id::generate(),
            new ArrayCollection($ticketData),
        );
    }
}
