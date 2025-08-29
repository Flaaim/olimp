<?php

namespace App\Parser\Entity\Ticket;

use ArrayObject;

final class Question
{
    private string $id;
    private string $number;
    private string $text;
    private string $questionMainImg;
    private ArrayObject $answers;
    public function __construct(string $id, string $number, string $text, string $questionMainImg, array $answers)
    {
        $this->id = $id;
        $this->number = $number;
        $this->text = $text;
        $this->questionMainImg = $questionMainImg;
        $this->answers = new ArrayObject($answers);
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getNumber(): string
    {
        return $this->number;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function getQuestionMainImg(): string
    {
        return $this->questionMainImg;
    }
    public function getAnswers(): array
    {
        return $this->answers->getArrayCopy();
    }
}
