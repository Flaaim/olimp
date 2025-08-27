<?php

namespace App\Parser\Service;

use App\Service\TextSanitizer;

final class TicketSanitizer
{
    public function __construct(private readonly TextSanitizer $sanitizer)
    {}

    public function sanitize(array $rawQuestions): array
    {
        return array_map(
            fn ($questionData) => [
                ...$questionData,
                'Text' => $this->cleanTextContent($questionData['Text']),
                'QuestionMainImg' => $questionData['QuestionMainImg'],
                'answers' => array_map(
                    fn ($answerData) => [
                        ...$answerData,
                        'Text' => $this->handleAnswerText($answerData['Text']),
                        'Correct' => $answerData['Correct'],
                        'Img' => $answerData['Img'],
                    ],
                    $questionData['answers']
                )
            ],
            $rawQuestions
        );
    }
    private function cleanTextContent(string $text): string
    {
        return $this->sanitizer->cleanTextContent($text);
    }
    private function handleAnswerText(string $text): string
    {
       return $this->sanitizer->cleanTextContent($text);
    }
}
