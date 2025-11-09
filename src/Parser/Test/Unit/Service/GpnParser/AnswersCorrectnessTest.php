<?php

namespace App\Parser\Test\Unit\Service\GpnParser;

use App\Parser\Service\Gpn\AnswersCorrectness;
use PHPUnit\Framework\TestCase;

class AnswersCorrectnessTest extends TestCase
{
    public function testChangeAnswers(): void
    {
        $answers = $this->getAnswers();
        $correctness = $this->getCorrectens();
        $answersCorrectness = new AnswersCorrectness();
        $answersCorrectness->updateAnswersCorrectness($answers, $correctness);

        self::assertEquals(
            $this->getChangedAnswers(), $answers
        );
    }

    private function getAnswers(): array
    {
        return [
                [
                    "id" => 0,
                    "content" =>
                        "<div><div>применение оборудования, приборов, механизмов (проверка исправностиоборудования, пусковых приборов и средств защиты)</div></div>",
                    "isCorrect" => false,
                ],
                [
                    "id" => 1,
                    "content" =>
                        "<div><div>оказание первой помощи пострадавшим</div></div>",
                    "isCorrect" => false,
                ],
                [
                    "id" => 2,
                    "content" =>
                        "<div><div>применение соответствующих СИЗ, их осмотр до и после использования</div></div>",
                    "isCorrect" => false,
                ],
                [
                    "id" => 3,
                    "content" =>
                        "<div><div>проведение спасательных мероприятий</div></div>",
                    "isCorrect" => false,
                ],
                [
                    "id" => 4,
                    "content" =>
                        "<div><div>разработка плана производства работ на высоте</div></div>",
                    "isCorrect" => false,
                ],
        ];
    }

    private function getCorrectens(): array
    {
        return [
            "IsCorrect" => false,
            "ItemsCorrectens" => [
                true,
                false,
                true,
                true,
                false
            ]
        ];
    }
    private function getChangedAnswers(): array
    {
        return [
            [
                "id" => 0,
                "content" =>
                    "<div><div>применение оборудования, приборов, механизмов (проверка исправностиоборудования, пусковых приборов и средств защиты)</div></div>",
                "isCorrect" => true,
            ],
            [
                "id" => 1,
                "content" =>
                    "<div><div>оказание первой помощи пострадавшим</div></div>",
                "isCorrect" => false,
            ],
            [
                "id" => 2,
                "content" =>
                    "<div><div>применение соответствующих СИЗ, их осмотр до и после использования</div></div>",
                "isCorrect" => true,
            ],
            [
                "id" => 3,
                "content" =>
                    "<div><div>проведение спасательных мероприятий</div></div>",
                "isCorrect" => true,
            ],
            [
                "id" => 4,
                "content" =>
                    "<div><div>разработка плана производства работ на высоте</div></div>",
                "isCorrect" => false,
            ],
        ];
    }
}
