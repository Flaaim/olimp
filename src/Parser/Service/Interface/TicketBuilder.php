<?php

namespace App\Parser\Service\Interface;

use App\Parser\Entity\Ticket\Ticket;

interface TicketBuilder
{
    public function build(array $questionsData): Ticket;
}
