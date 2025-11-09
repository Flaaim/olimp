<?php

namespace App\Parser\Test\Unit\Service\Common;

use App\Parser\Service\Common\CommonBuilder;
use PHPUnit\Framework\TestCase;

class CommonBuilderTest extends TestCase
{

    public function testSuccess(): void
    {
        $ticket = (new CommonBuilder())->build($this->getValidQuestions());

        $this->assertIsArray($ticket->getQuestions()->toArray());
        $this->assertEquals($this->getValidQuestions()[0]['Number'], $ticket->getQuestions()->get(0)->getNumber());
        $this->assertEquals($this->getValidQuestions()[0]['Text'], $ticket->getQuestions()->get(0)->getText());
        $this->assertEquals($this->getValidQuestions()[0]['QuestionMainImg'], $ticket->getQuestions()->get(0)->getQuestionMainImg());

        $this->assertIsArray(
            $ticket->getQuestions()->get(0)
                ->getAnswers()->toArray());


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
