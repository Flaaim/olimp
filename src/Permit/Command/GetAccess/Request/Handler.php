<?php

namespace App\Permit\Command\GetAccess\Request;

use App\Permit\Entity\Access\AccessRepository;
use App\Shared\Domain\Response\TicketResponse;
use App\Shared\Domain\ValueObject\Id;
use App\Ticket\Entity\TicketRepository;
use DateTimeImmutable;

class Handler
{
    public function __construct(
        private readonly AccessRepository $accesses,
        private readonly TicketRepository $tickets,
    )
    {}
    public function handle(Command $command): TicketResponse
    {

        $access = $this->accesses->findByToken($command->token);

        if(null === $access) {
            throw new \DomainException('Access not found.');
        }
        if($access->getToken()->isExpiredTo(new DateTimeImmutable())) {
            throw new \DomainException('Access token expired.');
        }

        $ticket = $this->tickets->getById(
            new Id($access->getTicketId())
        );

        return TicketResponse::fromResult($ticket);

    }
}
