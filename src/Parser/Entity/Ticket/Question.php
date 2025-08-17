<?php

namespace App\Parser\Entity\Ticket;

use App\Parser\Entity\Parser\Id;

class Question
{
    private string $id;
    private string $number;
    private string $text;
    private ?string $questionMainImg;
    public function __construct(string $id, string $number, string $text, string $questionMainImg)
    {
        $this->id = $id;
        $this->number = $number;
        $this->text = $text;
        $this->questionMainImg = $questionMainImg;
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
}
