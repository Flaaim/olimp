<?php

namespace App\Parser\Entity\Ticket;

use App\Parser\Entity\Parser\Id;
use ArrayObject;

class Ticket
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
        return $this->questions->getArrayCopy();
    }

}
