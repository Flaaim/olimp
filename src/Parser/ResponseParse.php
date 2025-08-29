<?php

namespace App\Parser;

use App\Parser\Entity\Ticket\Ticket;

class ResponseParse implements \JsonSerializable
{
    public function __construct(
        private readonly string $id,
        private readonly ?string $name,
        private readonly ?string $cipher,
        private readonly array $questions,
    )
    {}

    public static function fromTicket(Ticket $ticket): self
    {
        return new self(
            $ticket->getId()->getValue(),
            $ticket->getName(),
            $ticket->getCipher(),
            $ticket->getQuestions()
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cipher' => $this->cipher,
            'questions' => $this->questions,
        ];
    }
}
