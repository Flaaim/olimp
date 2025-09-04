<?php

namespace App\Parser\Command;

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
            $ticket->getQuestions(),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cipher' => $this->cipher,
            'questions' => array_map(
                fn($question) => [
                    'id' => $question->getId(),
                    'number' => $question->getNumber(),
                    'text' => $question->getText(),
                    'image' => $question->getQuestionMainImg(),
                    'answers' => array_map(
                        fn($answer) => [
                            'id' => $answer->getId()->getValue(),
                            'text' => $answer->getText(),
                            'isCorrect' => $answer->isCorrect(),
                            'image' => $answer->getImg(),
                        ], $question->getAnswers()
                    )
                ], $this->questions
            )
        ];
    }
}
