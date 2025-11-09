<?php

namespace App\Parser\Service\Gpn;

class AnswersCorrectness
{
    public function updateAnswersCorrectness(&$answers, $correctnessData): void
    {
        $countItems = count($correctnessData['ItemsCorrectens']);
        $countAnswers = count($answers);

        if($countItems !== $countAnswers) {
            throw new \DomainException('Count correctness items does not match number of answers.');
        }
        foreach($answers as $index => &$answer) {
            $answer['isCorrect'] = $correctnessData['ItemsCorrectens'][$index];

        }
        unset($answer);
    }

    public function updateOneAnswerCorrectness(&$answer, $correctnessData): void
    {
        if(!isset($correctnessData['IsCorrect'])) {
            throw new \DomainException('Answer is not a valid answer.');
        }
        $answer['isCorrect'] = $correctnessData['IsCorrect'];

    }
}
