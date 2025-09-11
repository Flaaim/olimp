<?php

namespace App\Ticket\Command\Delete\Request;

use App\Flusher;
use App\Parser\Entity\Parser\Id;
use App\Ticket\Command\Delete\Response\Response;
use App\Ticket\Entity\TicketRepository;

class Handler
{
    public function __construct(
        private readonly TicketRepository $tickets,
        private readonly Flusher $flusher
    )
    {}

    public function handle(Command $command): Response
    {
        $ticket = $this->tickets->getById(new Id($command->ticketId));

        $this->tickets->remove($ticket);

        $this->flusher->flush();

        return new Response($ticket->getId()->getValue());
    }
}
