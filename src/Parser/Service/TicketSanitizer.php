<?php

namespace App\Parser\Service;

use App\Parser\Entity\Parser\Host;

final class TicketSanitizer
{
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
        // Убираем HTML теги, но оставляем переносы строк
        $cleaned = strip_tags($text, '<br>');

        // Заменяем <br> на переносы строк
        $cleaned = str_replace(['<br>', '<br/>', '<br />'], "\n", $cleaned);

        // Убираем лишние пробелы и переносы
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        // Убираем дефисы в начале и конце
        $cleaned = preg_replace('/^-|-$/', '', $cleaned);

        return trim($cleaned);
    }

    private function handleAnswerText(string $text): string
    {
        return $this->cleanTextContent($text);
    }
}
