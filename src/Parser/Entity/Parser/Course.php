<?php

namespace App\Parser\Entity\Parser;

use Webmozart\Assert\Assert;

class Course
{
    private string $id;
    private string $ticketId;

    public function __construct(string $id, string $ticketId)
    {
        Assert::notEmpty($id);
        Assert::notEmpty($ticketId);
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
