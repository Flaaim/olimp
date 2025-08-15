<?php

namespace App\Parser\Service;

class QuestionDataHandler
{
    public function stripTagsTextField(string $text): string
    {
        $cleaned = strip_tags($text);
        return $this->normalizeWhitespace($cleaned);
    }

    public function normalizeWhitespace(string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}
