<?php

namespace App\Parser\Test\Unit\Builder;

use App\Parser\Entity\Parser\Id;
use App\Parser\Entity\Ticket\Ticket;

class TicketBuilder
{
    private Id $id;
    private \ArrayObject $questions;
    public function __construct()
    {
        $this->id = Id::generate();
        $this->questions = new \ArrayObject();
    }
    public function build(): Ticket
    {
        return new Ticket(
            $this->id,
            new \ArrayObject([
                (new QuestionBuilder())->build(),
            ])
        );
    }
}
