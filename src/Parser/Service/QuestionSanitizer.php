<?php

namespace App\Parser\Service;

use Webmozart\Assert\Assert;

class QuestionSanitizer
{
    private array $questions;
    public function __construct(array $questions)
    {
        Assert::notEmpty($questions);
        $this->questions = $questions;
    }

    public function sanitizeTextField(): self
    {
        $sanitized = array_map(
            fn ($questionData) => [
                ...$questionData,
                'Text' => $this->stripTagsTextField($questionData['Text']),
            ],
            $this->questions
        );
        return new self($sanitized);
    }

    public function getArray(): array
    {
        return $this->questions;
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
