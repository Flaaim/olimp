<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Ticket\Question;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    public function testFromArray(): void
    {
        $question = Question::fromArray($this->getArrayData());

        $this->assertEquals($this->getArrayData()['id'], $question->getId());
        $this->assertEquals($this->getArrayData()['number'], $question->getNumber());
        $this->assertEquals($this->getArrayData()['text'], $question->getText());
        $this->assertEquals($this->getArrayData()['image'], $question->getQuestionMainImg());

        $this->assertIsArray($question->getAnswers()->toArray());

    }
    public function testSetNewQuestionImage(): void
    {
        $question = Question::fromArray($this->getArrayData());
        $question->setQuestionMainImg($value ='/tmp/e587aa55-e210-40cf-80c1-4fab48209192/1.jpg');

        $this->assertEquals($value, $question->getQuestionMainImg());
    }
    private function getArrayData(): array
    {
        return [
            'id' => '49336cb09422414399ec69aa582f60e4',
            'number' => '1',
            'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
            'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg',
            'answers' => [
                [
                    'id' => 'e587aa55-e210-40cf-80c1-4fab48209192',
                    'text' => 'Кабель должен быть в кислостойком шланге',
                    'isCorrect' => true,
                    'image' => ''
                ],
                [
                    'id' => '6fb5b3db-2a8b-4c3b-95a0-c9c13ddae3a4',
                    'text' => 'Кабель должен иметь не более 3 скруток',
                    'isCorrect' => false,
                    'image' => ''
                ],
                [
                    'id' => 'e6dac57f-2c3d-43f2-87b4-79ba3b92c8ae',
                    'text' => 'Кабель должен быть только в тканевой оплетке',
                    'isCorrect' => false,
                    'image' => ''
                ],
                [
                    'id' => 'e09aa4b3-0474-4e25-90ba-240565a62a0a',
                    'text' => 'Кабель должен быть длиной не более 1,5 м',
                    'isCorrect' => false,
                    'image' => ''
                ]
            ]
        ];
    }
}
