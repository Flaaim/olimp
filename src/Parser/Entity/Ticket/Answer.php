<?php

namespace App\Parser\Entity\Ticket;

final class Answer
{
    private string $text;
    private bool $isCorrect;
    public function __construct(string $text, bool $isCorrect)
    {
        $this->text = $text;
        $this->isCorrect = $isCorrect;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }
}
