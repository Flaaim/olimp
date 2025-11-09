<?php

namespace App\Parser\Service\Gpn;

use App\Parser\Entity\Ticket\Ticket;
use App\Parser\Service\Interface\TicketBuilder;
use Ramsey\Uuid\Uuid;

final class GpnBuilder implements TicketBuilder
{
    public function build(array $questionsData): Ticket
    {
        $ticket = [];
        $ticket['id'] = Uuid::uuid4()->toString();
        $ticket['cipher'] = $questionsData['cipher'] ?? null;
        $ticket['name'] = $questionsData['name'] ?? null;
        $ticket['questions'] = array_map(
            fn($index, $question) => [
                'id' => Uuid::uuid4()->toString(),
                'number' => $index + 1,
                'text' => $question['content'],
                'image' => $question['questionImg'],
                'answers' => array_map(
                    fn($answer) => [
                        'id' => UUID::uuid4()->toString(),
                        'text' => $answer['content'],
                        'isCorrect' => $answer['isCorrect'],
                        'image' => $answer['Img'],
                    ], $question['answers']
                )
            ], array_keys($questionsData), array_values($questionsData)
        );

        return Ticket::fromArray($ticket);
    }
}
