<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Entity\Ticket\Question;
use App\Parser\Service\TicketBuilder;
use PHPUnit\Framework\TestCase;

class TicketBuilderTest extends TestCase
{

    public function testSuccess(): void
    {
        $questions = (new TicketBuilder())->build($this->getValidQuestions());

        $this->assertNotNull($questions);
        $this->assertInstanceOf(Question::class, $questions[0]);

        $this->assertEquals($this->getValidQuestions()[0]['Id'], $questions[0]->getId());
        $this->assertEquals($this->getValidQuestions()[0]['Number'], $questions[0]->getNumber());
        $this->assertEquals($this->getValidQuestions()[0]['Text'], $questions[0]->getText());
        $this->assertEquals($this->getValidQuestions()[0]['QuestionMainImg'], $questions[0]->getQuestionMainImg());
        $this->assertEquals($this->getValidQuestions()[0]['answers'][0]['Text'], $questions[0]->getAnswers()[0]->getText());

    }
    private function getValidQuestions(): array
    {
        return [
            [
                'Id' => '26a4ddb9a4d04519b0ffbc428fb2113e',
                'Number' => 1,
                'Text' => '<div><div>Как с минимальным риском подняться на крышу здания?</div></div>',
                'QuestionMainImg' => '<div><div><img style="width: 300px;" src="/QuestionImages/c35375/26a4ddb9-a4d0-4519-b0ff-bc428fb2113e/8/1.jpg" xmlns:xd="http://schemas.microsoft.com/office/infopath/2003" xd:content-type="png" /></div></div>',
                'answers' => [
                    [
                        "Text" => "<div><div>Кабель должен быть в кислостойком шланге</div></div>",
                        "Correct" => true,
                        'Img' => ''
                    ],
                    [
                        "Text" => "<div><div><div>Кабель должен иметь не более 3 скруток</div></div></div>",
                        "Correct" => false,
                        'Img' => ''
                    ],
                    [
                        "Text" => "<div><div>Кабель должен быть только в тканевой оплетке</div></div>",
                        "Correct" => false,
                        'Img' => ''
                    ],
                    [
                        "Text" => "<div><div>Кабель должен быть длиной не более 1,5 м</div></div>",
                        "Correct" => false,
                        'Img' => ''
                    ]
                ]

            ]
        ];
    }
}
