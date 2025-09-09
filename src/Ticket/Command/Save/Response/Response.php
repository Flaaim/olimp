<?php

namespace App\Ticket\Command\Save\Response;

use App\Parser\Entity\Ticket\Ticket;
use Webmozart\Assert\Assert;

class Response implements \JsonSerializable
{
    public function __construct(
        private readonly string  $id,
        private readonly ?string $name,
        private readonly ?string $cipher,
        private readonly array $questions,
    ){}

    public static function fromResult(Ticket $ticket): self
    {

        return new self(
            $ticket->getId(),
            $ticket->getName(),
            $ticket->getCipher(),
            $ticket->getQuestions()->toArray(),
        );
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cipher' => $this->cipher,
            'questions' => array_map(
                fn ($question) => [
                    'id' => $question->getId(),
                    'number' => $question->getNumber(),
                    'text' => $question->getText(),
                    'image' => $question->getQuestionMainImg(),
                ], $this->questions
            )
        ];
    }
}
