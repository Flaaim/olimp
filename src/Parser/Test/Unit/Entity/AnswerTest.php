<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Ticket\Answer;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    public function testFromArray()
    {
        $answer = Answer::fromArray($this->getArrayData());

        $this->assertEquals($this->getArrayData()['id'], $answer->getId());
        $this->assertEquals($this->getArrayData()['text'], $answer->getText());
        $this->assertEquals($this->getArrayData()['isCorrect'], $answer->isCorrect());
        $this->assertEquals($this->getArrayData()['image'], $answer->getImg());
    }

    private function getArrayData(): array
    {
        return                 [
            'id' => 'e587aa55-e210-40cf-80c1-4fab48209192',
            'text' => 'Кабель должен быть в кислостойком шланге',
            'isCorrect' => true,
            'image' => ''
        ];
    }
}
