<?php

namespace App\Ticket\Entity;

use App\Parser\Entity\Ticket\Ticket;

interface TicketRepository
{
    public function add(Ticket $ticket): void;
}
