<?php

namespace App\Ticket\Test\Unit\Service;

use App\Parser\Entity\Ticket\Ticket;
use App\Ticket\Service\ImageDownloader\PathConverter;
use App\Ticket\Service\ImageDownloader\UrlBuilder;
use PHPUnit\Framework\TestCase;

class PathConverterTest extends TestCase
{
    public function testConvertSuccess(): void
    {
        $converter = new PathConverter($this->getUrlBuilder());
        $ticket = Ticket::fromArray($this->getArrayData());

        $converter->convert($ticket, $this->getResultDownload());
        $this->assertEquals($ticket->getQuestions()->toArray(), $this->expectedResult());
    }

    private function getUrlBuilder(): UrlBuilder
    {
        return new UrlBuilder('http://localhost/QuestionImages');
    }
    private function getArrayData(): array
    {

        return [
            'id' => '90f3b701-3602-4050-a27f-a246ee980fe7',
            'name' => null,
            'cipher' => null,
            'questions' => [
                [
                    'id' => '49336cb09422414399ec69aa582f60e4',
                    'number' => '1',
                    'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg',
                ]
            ]
        ];

    }

    private function getResultDownload(): array
    {
        return [
                [
                    "question_id" => "49336cb09422414399ec69aa582f60e4",
                    "url" => "http://olimpoks.chukk.ru:82/QuestionImages/c37670/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg",
                    "status" => "success",
                    "path" => "/app/config/common/../../public/QuestionImages/fb87c290-07de-4183-b67b-d4d697ff7f04/969f4b34-43e4-4f76-bc0e-b02f8633734e/1.jpg",
                ]
        ];
    }

    private function expectedResult(): array
    {
        $expectedArrayData = [
            'id' => '90f3b701-3602-4050-a27f-a246ee980fe7',
            'name' => null,
            'cipher' => null,
            'questions' => [
                [
                    'id' => '49336cb09422414399ec69aa582f60e4',
                    'number' => '1',
                    'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
                    'image' => 'http://localhost/QuestionImages/fb87c290-07de-4183-b67b-d4d697ff7f04/969f4b34-43e4-4f76-bc0e-b02f8633734e/1.jpg',
                ]
            ]
        ];
        $ticket = Ticket::fromArray($expectedArrayData);
        return $ticket->getQuestions()->toArray();
    }
}
