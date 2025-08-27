<?php

namespace App\Parser\Entity\Ticket;

final class Answer
{
    private string $text;
    private bool $isCorrect;
    private string $img;
    public function __construct(string $text, bool $isCorrect, string $img)
    {
        $this->text = $text;
        $this->isCorrect = $isCorrect;
        $this->img = $img;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }
    public function getImg(): string
    {
        return $this->img;
    }
}
