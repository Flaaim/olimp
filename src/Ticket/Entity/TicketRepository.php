<?php

namespace App\Ticket\Entity;

use App\Parser\Entity\Ticket\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TicketRepository
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly EntityRepository $repo)
    {}
    public function add(Ticket $ticket): void
    {
        $this->em->persist($ticket);
    }
}
