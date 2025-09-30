<?php

namespace App\Parser\Service;

use App\Parser\Entity\Ticket\Ticket;
use Ramsey\Uuid\Uuid;

final class TicketBuilder
{
    public function build(array $questionsData): Ticket
    {
        $ticket = [];
        $ticket['id'] = Uuid::uuid4()->toString();
        $ticket['cipher'] = $questionsData['cipher'] ?? null;
        $ticket['name'] = $questionsData['name'] ?? null;
        $ticket['price'] = $questionsData['price'] ?? null;
        $ticket['questions'] = array_map(
            fn($question) => [
                'id' => Uuid::uuid4()->toString(),
                'number' => $question['Number'],
                'text' => $question['Text'],
                'image' => $question['QuestionMainImg'],
                'answers' => array_map(
                    fn($answer) => [
                        'id' => UUID::uuid4()->toString(),
                        'text' => $answer['Text'],
                        'isCorrect' => $answer['Correct'],
                        'image' => $answer['Img'],
                    ], $question['answers']
                )
            ], $questionsData
        );

        return Ticket::fromArray($ticket);
    }
}
