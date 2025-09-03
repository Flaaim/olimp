<?php

namespace App\Parser\Service;

use App\Parser\Entity\Ticket\Ticket;

class TicketProcessor
{
    private TicketBuilder $builder;
    private TicketSanitizer $sanitizer;
    private TicketValidator $validator;
    private TicketImageHandler $imageHandler;

    public function __construct(
        TicketSanitizer $sanitizer,
        TicketBuilder $builder,
        TicketValidator $validator,
        TicketImageHandler $imageHandler
    )
    {
        $this->sanitizer = $sanitizer;
        $this->builder = $builder;
        $this->validator = $validator;
        $this->imageHandler = $imageHandler;
    }

    public function createTicket(array $rawQuestions): Ticket
    {
        $this->validator->validate($rawQuestions);
        $withImages = $this->imageHandler->handle($rawQuestions);
        $sanitized = $this->sanitizer->sanitize($withImages);

        return $this->builder->build($sanitized);
    }
}
