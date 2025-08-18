<?php

namespace App\Parser\Entity\Ticket;

use App\Parser\Entity\Parser\Id;
use ArrayObject;

final class Ticket
{
    private Id $id;
    private ArrayObject $questions;

    public function __construct(Id $id, ArrayObject $questions)
    {
        $this->id = $id;
        $this->questions = $questions;
    }
    public function getId(): Id
    {
        return $this->id;
    }
    public function getQuestions(): array
    {
        $result = [];
        foreach ($this->questions as $question) {
            $result[] = [
                'id' => $question->getId(),
                'number' => $question->getNumber(),
                'text' => $question->getText(),
                'image' => $question->getQuestionMainImg(),
                'answers' => $question->getAnswers(),
            ];
        }
        return $result;
    }

}
