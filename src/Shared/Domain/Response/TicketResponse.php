<?php

namespace App\Shared\Domain\Response;

use App\Parser\Entity\Ticket\Ticket;

class TicketResponse implements \JsonSerializable
{
    public function __construct(
        public readonly string  $id,
        public readonly ?string $name,
        public readonly ?string $cipher,
        public readonly string  $status,
        public readonly ?float $price,
        public readonly array $questions,
    ){}

    public static function fromResult(Ticket $ticket, $limit = null): self
    {
        $price = null;

        if($ticket->hasPrice()) {
            $price = $ticket->getPrice()->getValue();
        }

        return new self(
            $ticket->getId(),
            $ticket->getName(),
            $ticket->getCipher(),
            $ticket->getStatus()->getValue(),
            $price,
            $ticket->getQuestions()->slice(0, $limit),
        );
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cipher' => $this->cipher,
            'status' => $this->status,
            'price' => $this->price,
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
