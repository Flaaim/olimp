<?php

namespace App\Parser\Service;

use App\Parser\Entity\Ticket\Question;
use Webmozart\Assert\Assert;

final class QuestionsBuilder
{
    public function build(array $questionData): array
    {
        return array_map(
            fn($questionData): Question => new Question(
                $questionData['Id'],
                $questionData['Number'],
                $questionData['Text'],
                $questionData['QuestionMainImg'],
            ),
            $questionData
        );
    }
}
