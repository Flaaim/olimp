<?php

namespace App\Parser\Service;

use App\Parser\Entity\Ticket\Answer;
use App\Parser\Entity\Ticket\Question;

final class TicketBuilder
{
    public function build(array $questionData): array
    {
        return array_map(
            fn($questionData): Question => new Question(
                $questionData['Id'],
                $questionData['Number'],
                $questionData['Text'],
                $questionData['QuestionMainImg'],
                $this->buildAnswers($questionData['answers'])
            ),
            $questionData
        );
    }

    public function buildAnswers(array $answerData): array
    {
        return array_map(
            fn($answerData): Answer => new Answer(
                $answerData['Text'],
                $answerData['Correct'],
            ),
            $answerData
        );
    }
}
