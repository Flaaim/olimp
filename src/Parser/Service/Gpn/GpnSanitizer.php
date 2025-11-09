<?php

namespace App\Parser\Service\Gpn;

use App\Parser\Service\Interface\TicketSanitizer;
use App\Service\TextSanitizer;

final class GpnSanitizer implements TicketSanitizer
{
    public function __construct(private readonly TextSanitizer $sanitizer)
    {}

    public function sanitize(array $rawQuestions): array
    {
        return array_map(
            fn ($questionData) => [
                ...$questionData,
                'content' => $this->cleanTextContent($questionData['content']),
                'questionImg' => $questionData['questionImg'],
                'answers' => array_map(
                    fn ($answerData) => [
                        ...$answerData,
                        'content' => $this->handleAnswerText($answerData['content']),
                        'isCorrect' => $answerData['isCorrect'],
                        'Img' => $answerData['Img'] ?? '',
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
