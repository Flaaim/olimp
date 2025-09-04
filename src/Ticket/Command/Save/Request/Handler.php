<?php

namespace App\Ticket\Command\Save\Request;

use App\Flusher;
use App\Parser\Entity\Ticket\Ticket;
use App\Ticket\Command\Save\Response\Response;
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
        $ticket = Ticket::fromArray($command->ticket);

        $this->tickets->add($ticket);

        $this->flusher->flush();

        return new Response(
            $ticket->getId()->getValue(),
            $ticket->getName(),
            $ticket->getCipher()
        );
    }
}
