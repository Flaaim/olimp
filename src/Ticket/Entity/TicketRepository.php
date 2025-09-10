<?php

namespace App\Ticket\Entity;

use App\Parser\Entity\Ticket\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TicketRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly EntityRepository $repo
    )
    {}
    public function addOrUpdate(Ticket $ticket): void
    {
        $existing = $this->findExisting($ticket);
        if($existing) {
            $existing->updateFrom($ticket);
        }else{
            $this->em->persist($ticket);
        }
        $this->em->flush();
    }
    private function findExisting(Ticket $ticket): ?Ticket
    {
        return $this->repo->find($ticket->getId()->getValue());
    }
}
