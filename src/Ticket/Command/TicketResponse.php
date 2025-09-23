<?php

namespace App\Ticket\Command;

use App\Parser\Entity\Ticket\Ticket;

class TicketResponse implements \JsonSerializable
{
    public function __construct(
        private readonly string  $id,
        private readonly ?string $name,
        private readonly ?string $cipher,
        private readonly string  $status,
        private readonly array $questions,
    ){}

    public static function fromResult(Ticket $ticket): self
    {

        return new self(
            $ticket->getId(),
            $ticket->getName(),
            $ticket->getCipher(),
            $ticket->getStatus()->getValue(),
            $ticket->getQuestions()->toArray(),
        );
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cipher' => $this->cipher,
            'status' => $this->status,
            'questions' => array_map(
                fn ($question) => [
                    'id' => $question->getId(),
                    'number' => $question->getNumber(),
                    'text' => $question->getText(),
                    'image' => $question->getQuestionMainImg(),
                    'answers' => array_map(
                        fn ($answer) => [
                            'id' => $answer->getId()->getValue(),
                            'text' => $answer->getText(),
                            'isCorrect' => $answer->isCorrect(),
                            'image' => $answer->getImg(),
                        ], $question->getAnswers()->toArray()
                    )
                ], $this->questions
            )
        ];
    }
}
