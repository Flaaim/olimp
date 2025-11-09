<?php

namespace App\Parser\Test\Unit\Service\Common;

use App\Parser\Service\Common\CommonSanitizer;
use App\Service\TextSanitizer;
use PHPUnit\Framework\TestCase;

class CommonSanitizerTest extends TestCase
{
    public function testSuccess(): void
    {
        $sanitized = (new CommonSanitizer(new TextSanitizer()))->sanitize($this->getQuestionsWithTags());

        $this->assertEquals($this->getSanitizedQuestions(), $sanitized);
    }

    private function getQuestionsWithTags(): array
    {
        return [
            [
                'Text' => '<div><div>Как с минимальным риском подняться на крышу здания?</div></div>',
                'QuestionMainImg' => '',
                'answers' => [
                    [
                        "Text" => "<div><div>Кабель должен быть в кислостойком шланге</div></div>",
                        "Correct" => true,
                        "Img" => null
                    ],
                    [
                        "Text" => "<div><div><div>Кабель должен иметь не более 3 скруток</div></div></div>",
                        "Correct" => false,
                        "Img" => null
                    ],
                    [
                        "Text" => "<div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><img src=\"/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/1.jpg\" width=\"350\" height=\"191\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>-<div><div>\"Запрещается прикасаться. Опасно\"</div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>",
                        "Correct" => false,
                        "Img" => null
                    ],
                    [
                        "Text" => "<div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><img src=\"/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/2.jpg\" width=\"350\" height=\"191\" data-mce-selected=\"1\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>-<div>\"Осторожно. Возможно травмирование рук\"</div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>",
                        "Correct" => false,
                        "Img" => null
                    ]
                ]
            ]
        ];
    }

    private function getSanitizedQuestions(): array
    {
        return [
            array(
                'Text' => 'Как с минимальным риском подняться на крышу здания?',
                'QuestionMainImg' => '',
                'answers' => [
                    [
                        "Text" => "Кабель должен быть в кислостойком шланге",
                        "Correct" => true,
                        "Img" => null
                    ],
                    [
                        "Text" => "Кабель должен иметь не более 3 скруток",
                        "Correct" => false,
                        "Img" => null
                    ],
                    [
                        "Text" => '"Запрещается прикасаться. Опасно"',
                        "Correct" => false,
                        "Img" => null
                    ],
                    [
                        "Text" => '"Осторожно. Возможно травмирование рук"',
                        "Correct" => false,
                        "Img" => null
                    ]
                ]
            )
        ];
    }

}
