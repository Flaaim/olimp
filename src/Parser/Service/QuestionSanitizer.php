<?php

namespace App\Parser\Service;

final class QuestionSanitizer
{
    public function sanitize(array $rawQuestions): array
    {
        return array_map(
            fn ($questionData) => [
                ...$questionData,
                'Text' => $this->stripTagsTextField($questionData['Text']),
            ],
            $rawQuestions
        );
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
}
