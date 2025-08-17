<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Entity\Parser\Host;
use App\Parser\Entity\Parser\HostMapper;
use App\Parser\Entity\Ticket\Ticket;
use App\Parser\Service\QuestionProcessor;
use App\Parser\Service\QuestionSanitizer;
use App\Parser\Service\QuestionsBuilder;
use PHPUnit\Framework\TestCase;

class QuestionProcessorTest extends TestCase
{
    public function testSuccess(): void
    {
        $processor = new QuestionProcessor(
            $this->getSanitizer(),
            $this->getBuilder(),
        );

        $this->assertInstanceOf(Ticket::class, $processor->createTicket($this->getValidQuestions()));

    }
    public function testEmpty(): void
    {
        $processor = new QuestionProcessor(
            $this->getSanitizer(),
            $this->getBuilder(),
        );
        $this->expectException(\InvalidArgumentException::class);
        $processor->createTicket([]);
    }
    public function testInvalidFields(): void
    {
        $processor = new QuestionProcessor(
            $this->getSanitizer(),
            $this->getBuilder(),
        );
        $this->expectException(\InvalidArgumentException::class);
        $processor->createTicket($this->getInvalidQuestions());

    }


    private function getSanitizer(): QuestionSanitizer
    {
        return new QuestionSanitizer($this->getHost());
    }
    private function getBuilder(): QuestionsBuilder
    {
        return new QuestionsBuilder();
    }

    private function getValidQuestions(): array
    {
        return [
            [
                '__type' => 'f__AnonymousType12`4[[System.Guid',
                'Id' => '26a4ddb9a4d04519b0ffbc428fb2113e',
                'Number' => 1,
                'Text' => '<div><div>Как с минимальным риском подняться на крышу здания?</div></div>',
                'QuestionMainImg' => '<div><div><img style="width: 300px;" src="/QuestionImages/c35375/26a4ddb9-a4d0-4519-b0ff-bc428fb2113e/8/1.jpg" xmlns:xd="http://schemas.microsoft.com/office/infopath/2003" xd:content-type="png" /></div></div>'
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
                'QuestionMainImg' => '<div><div><img style="width: 300px;" src="/QuestionImages/c35375/26a4ddb9-a4d0-4519-b0ff-bc428fb2113e/8/1.jpg" xmlns:xd="http://schemas.microsoft.com/office/infopath/2003" xd:content-type="png" /></div></div>'
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
