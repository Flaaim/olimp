<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Entity\Parser\Host;
use App\Parser\Entity\Parser\HostMapper;
use App\Parser\Service\TicketImageHandler;
use App\Service\ImageHandler;
use PHPUnit\Framework\TestCase;

class TicketImageHandlerTest extends TestCase
{
    public function testSuccess(): void
    {
        $handler = (new TicketImageHandler(
            new ImageHandler(
                $this->getHost(),
            )
        ))->handle($this->getQuestionsWithTags());

        $this->assertEquals($this->getQuestionsWithHandledImages(), $handler);
    }



    private function getQuestionsWithTags(): array
    {
        return [
            [
                'Text' => '',
                'QuestionMainImg' => '',
                'answers' => [
                    [
                        "Text" => "",
                        "Correct" => true,
                        "Img" => null
                    ],
                    [
                        "Text" => "",
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

    public function getQuestionsWithHandledImages(): array
    {
        return [
            [
                'Text' => '',
                'QuestionMainImg' => '',
                'answers' => [
                    [
                        "Text" => "",
                        "Correct" => true,
                        "Img" => ""
                    ],
                    [
                        "Text" => "",
                        "Correct" => false,
                        "Img" => ""
                    ],
                    [
                        "Text" => "<div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><img src=\"/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/1.jpg\" width=\"350\" height=\"191\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>-<div><div>\"Запрещается прикасаться. Опасно\"</div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>",
                        "Correct" => false,
                        "Img" => "<img src=\"{$this->getHost()->getValue()}QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/1.jpg\">"
                    ],
                    [
                        "Text" => "<div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><img src=\"/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/2.jpg\" width=\"350\" height=\"191\" data-mce-selected=\"1\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>-<div>\"Осторожно. Возможно травмирование рук\"</div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>",
                        "Correct" => false,
                        "Img" => "<img src=\"{$this->getHost()->getValue()}QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/2.jpg\">"
                    ]
                ]
            ]
        ];
    }

    private function getHost(): Host
    {
        $hosts = [
            'http://prk.kuzstu.ru:9001/',
            'http://olimpoks.chukk.ru:82/'
        ];
        $mapper = new HostMapper($hosts);
        return new Host('http://olimpoks.chukk.ru:82/', $mapper);
    }
}
