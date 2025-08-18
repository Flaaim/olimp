<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Service\TicketValidator;
use PHPUnit\Framework\TestCase;

class TicketValidatorTest extends TestCase
{
    public function testSuccess(): void
    {
        $validator = new TicketValidator();
        $validator->validate($this->getValidQuestions());


        $this->expectNotToPerformAssertions();
    }

    public function testEmpty(): void
    {
        $validator = new TicketValidator();
        $this->expectException(\InvalidArgumentException::class);
        $validator->validate([]);
    }

    public function testInvalidQuestion(): void
    {
        $validator = new TicketValidator();
        $this->expectException(\InvalidArgumentException::class);

        $validator->validate($this->getInvalidQuestions());
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
                        "Correct" => true
                    ],
                    [
                        "Text" => "<div><div><div>Кабель должен иметь не более 3 скруток</div></div></div>",
                        "Correct" => false
                    ],
                    [
                        "Text" => "<div><div>Кабель должен быть только в тканевой оплетке</div></div>",
                        "Correct" => false
                    ],
                    [
                        "Text" => "<div><div>Кабель должен быть длиной не более 1,5 м</div></div>",
                        "Correct" => false
                    ]
                ]

            ]
        ];
    }

    private function getInvalidQuestions(): array
    {
        return [
            [
                '__type' => 'f__AnonymousType12`4[[System.Guid',
                'dd' => '26a4ddb9a4d04519b0ffbc428fb2113e',
                'umber' => 1,
                'Text' => '<div><div>Как с минимальным риском подняться на крышу здания?</div></div>',
                'QuestionMainImg' => '<div><div><img style="width: 300px;" src="/QuestionImages/c35375/26a4ddb9-a4d0-4519-b0ff-bc428fb2113e/8/1.jpg" xmlns:xd="http://schemas.microsoft.com/office/infopath/2003" xd:content-type="png" /></div></div>',
                'answers' => [
                    "__type" => "<>f__AnonymousType0`2[[System.String, mscorlib],[System.Boolean, mscorlib]], Olimp.Archive",
                    "Text" => "<div><div>Кабель должен быть в кислостойком шланге</div></div>",
                    "Correct" => true
                ]
            ]
        ];
    }
}
