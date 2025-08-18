<?php

namespace App\Parser\Service;

use App\Parser\Entity\Parser\Host;

final class TicketSanitizer
{
    private Host $host;
    public function __construct(Host $host)
    {
        $this->host = $host;
    }
    public function sanitize(array $rawQuestions): array
    {
        return array_map(
            fn ($questionData) => [
                ...$questionData,
                'Text' => $this->stripTagsTextField($questionData['Text']),
                'QuestionMainImg' => $this->getImagePath($questionData['QuestionMainImg']),
                'answers' => array_map(
                    fn ($answerData) => [
                        ...$answerData,
                        'Text' => $this->handleAnswerText($answerData['Text']),
                        'Correct' => $answerData['Correct'],
                    ],
                    $questionData['answers']
                )
            ],
            $rawQuestions
        );
    }
    private function getImagePath(string $img): string
    {
        if (preg_match('/src="\/([^"]+)"/', $img, $matches)) {
            return $this->host->getValue(). $matches[1]; // QuestionImages/c2050/.../1.jpg
        }
        return $img;
    }
    private function stripTagsTextField(string $text): string
    {
        $cleaned = strip_tags($text);
        return $this->normalizeWhitespace($cleaned);
    }

    private function normalizeWhitespace(string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }

    private function handleAnswerText(string $text): string
    {
        if(preg_match('/src="\/(.+?)".*?<div>"(.+?)"<\/div>/s', $text, $matches)) {
            if(count($matches) === 3) {
                return $this->createImgTag($matches[1]) . ' - ' . $matches[2];
            }
        }
        return $this->stripTagsTextField($text);
    }

    private function createImgTag(string $url): string
    {
        return '<img src="' . $this->host->getValue(). $url . '">';
    }
}
