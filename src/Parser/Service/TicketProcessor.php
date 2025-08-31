<?php

namespace App\Parser\Service;

use App\Parser\Entity\Parser\Id;
use App\Parser\Entity\Ticket\Ticket;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

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
        $questions = $this->builder->build($sanitized);

        return new Ticket(
            new Id(Uuid::uuid4()->toString()),
            new ArrayCollection($questions)
        );
    }
}
