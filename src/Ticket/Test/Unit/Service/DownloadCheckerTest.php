<?php

namespace App\Ticket\Test\Unit\Service;

use App\Parser\Entity\Ticket\Answer;
use App\Parser\Entity\Ticket\Question;
use App\Parser\Entity\Ticket\Ticket;
use App\Ticket\Service\ImageDownloader\DownloadChecker;
use PHPUnit\Framework\TestCase;

class DownloadCheckerTest extends TestCase
{
    public function testShouldDownloadQuestionTrue(): void
    {
        $checker = new DownloadChecker();
        $question = Question::fromArray($this->questionAndAnswersNotEmpty());

        $this->assertTrue($checker->shouldDownloadQuestionImage($question));

        $question = Question::fromArray($this->questionNotEmptyAnswersEmpty());
        $this->assertTrue($checker->shouldDownloadQuestionImage($question));

        $question = Question::fromArray($this->questionEmptyAnswersNotEmpty());
        $this->assertTrue($checker->shouldDownloadQuestionImage($question));
    }


    public function testShouldDownloadQuestionFalse(): void
    {
        $checker = new DownloadChecker();
        $question = Question::fromArray($this->questionEmptyAnswersEmpty());

        $this->assertFalse($checker->shouldDownloadQuestionImage($question));

    }

    public function testShouldDownloadAnswerTrue(): void
    {
        $checker = new DownloadChecker();
        $question = Question::fromArray($this->questionAndAnswersNotEmpty());

        foreach ($question->getAnswers() as $answer) {
            $this->assertTrue($checker->shouldDownloadAnswerImage($answer));
        }

        $question = Question::fromArray($this->questionEmptyAnswersNotEmpty());
        foreach ($question->getAnswers() as $answer) {
            $this->assertTrue($checker->shouldDownloadAnswerImage($answer));
        }
    }
    private function questionNotEmptyAnswersEmpty(): array
    {
        return [
                'id' => '49336cb09422414399ec69aa582f60e4',
                'number' => '1',
                'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
                'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg',
                'answers' => [
                    [
                        "id" => "30604d45-60be-4316-8f97-58f2cfa18fda",
                        "text" => "Кабель должен быть в кислостойком шланге",
                        "isCorrect" => true,
                        "image" => ""
                    ],
                    [
                        "id" => "71a6e6e9-6215-41e6-a5ac-745f86182730",
                        "text" => "Кабель должен иметь не более 3 скруток",
                        "isCorrect" => false,
                        "image" => ""
                    ]
                ],

        ];
    }
    private function questionAndAnswersNotEmpty(): array
    {
        return [
            'id' => '49336cb09422414399ec69aa582f60e4',
            'number' => '1',
            'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
            'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg',
            'answers' => [
                [
                    "id" => "30604d45-60be-4316-8f97-58f2cfa18fda",
                    "text" => "Кабель должен быть в кислостойком шланге",
                    "isCorrect" => true,
                    "image" => "http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/1.jpg"
                ],
                [
                    "id" => "71a6e6e9-6215-41e6-a5ac-745f86182730",
                    "text" => "Кабель должен иметь не более 3 скруток",
                    "isCorrect" => false,
                    "image" => "http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/2.jpg"
                ]
            ],

        ];
    }

    private function questionEmptyAnswersEmpty(): array
    {
        return [
            'id' => '49336cb09422414399ec69aa582f60e4',
            'number' => '1',
            'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
            'image' => '',
            'answers' => [
                [
                    "id" => "30604d45-60be-4316-8f97-58f2cfa18fda",
                    "text" => "Кабель должен быть в кислостойком шланге",
                    "isCorrect" => true,
                    "image" => ""
                ],
                [
                    "id" => "71a6e6e9-6215-41e6-a5ac-745f86182730",
                    "text" => "Кабель должен иметь не более 3 скруток",
                    "isCorrect" => false,
                    "image" => ""
                ]
            ],

        ];
    }

    private function questionEmptyAnswersNotEmpty(): array
    {
        return [
            'id' => '49336cb09422414399ec69aa582f60e4',
            'number' => '1',
            'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
            'image' => '',
            'answers' => [
                [
                    "id" => "30604d45-60be-4316-8f97-58f2cfa18fda",
                    "text" => "Кабель должен быть в кислостойком шланге",
                    "isCorrect" => true,
                    "image" => "http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/1.jpg"
                ],
                [
                    "id" => "71a6e6e9-6215-41e6-a5ac-745f86182730",
                    "text" => "Кабель должен иметь не более 3 скруток",
                    "isCorrect" => false,
                    "image" => "http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/2.jpg"
                ]
            ],

        ];
    }
}
