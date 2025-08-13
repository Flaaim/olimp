<?php

namespace App\Parser\Entity;

class Course
{
    private string $id;
    private string $ticketId;

    public function __construct(string $id, string $ticketId)
    {
        $this->id = $id;
        $this->ticketId = $ticketId;
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getTicketId(): string
    {
        return $this->ticketId;
    }
}
