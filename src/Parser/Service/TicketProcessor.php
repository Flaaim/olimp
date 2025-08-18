<?php

namespace App\Parser\Service;

use App\Parser\Entity\Parser\Id;
use App\Parser\Entity\Ticket\Ticket;
use ArrayObject;
use Ramsey\Uuid\Uuid;

class TicketProcessor
{
    private TicketBuilder $builder;
    private TicketSanitizer $sanitizer;
    private TicketValidator $validator;

    public function __construct(TicketSanitizer $sanitizer, TicketBuilder $builder, TicketValidator $validator)
    {
        $this->sanitizer = $sanitizer;
        $this->builder = $builder;
        $this->validator = $validator;
    }
    public function createTicket(array $rawQuestions): Ticket
    {
        $this->validator->validate($rawQuestions);
        $sanitized = $this->sanitizer->sanitize($rawQuestions);
        $questions = $this->builder->build($sanitized);

        return new Ticket(
            new Id(Uuid::uuid4()->toString()),
            new ArrayObject($questions)
        );
    }
}
