<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Entity\Parser\Host;
use App\Parser\Entity\Parser\HostMapper;
use App\Parser\Entity\Ticket\Ticket;
use App\Parser\Service\TicketImageHandler;
use App\Parser\Service\TicketProcessor;
use App\Parser\Service\TicketSanitizer;
use App\Parser\Service\TicketBuilder;
use App\Parser\Service\TicketValidator;
use App\Service\ImageHandler;
use App\Service\TextSanitizer;
use PHPUnit\Framework\TestCase;

class TicketProcessorTest extends TestCase
{
    public function testSuccess(): void
    {
        $processor = new TicketProcessor(
            $this->getSanitizer(),
            $this->getBuilder(),
            $this->getTicketValidator(),
            $this->getTicketImageHandler()
        );

        $this->assertInstanceOf(Ticket::class, $processor->createTicket($this->getValidQuestions()));

    }
    public function testEmpty(): void
    {
        $processor = new TicketProcessor(
            $this->getSanitizer(),
            $this->getBuilder(),
            $this->getTicketValidator(),
            $this->getTicketImageHandler()
        );
        $this->expectException(\InvalidArgumentException::class);
        $processor->createTicket([]);
    }
    public function testInvalidFields(): void
    {
        $processor = new TicketProcessor(
            $this->getSanitizer(),
            $this->getBuilder(),
            $this->getTicketValidator(),
            $this->getTicketImageHandler()
        );
        $this->expectException(\InvalidArgumentException::class);
        $processor->createTicket($this->getInvalidQuestions());

    }


    private function getSanitizer(): TicketSanitizer
    {
        return new TicketSanitizer(new TextSanitizer());
    }
    private function getBuilder(): TicketBuilder
    {
        return new TicketBuilder();
    }
    private function getTicketValidator(): TicketValidator
    {
        return new TicketValidator();
    }

    private function getTicketImageHandler(): TicketImageHandler
    {
        return new TicketImageHandler(
            new ImageHandler(
                $this->getHost()
            )
        );
    }
    private function getValidQuestions(): array
    {
        return [
            [
                '__type' => 'f__AnonymousType12`4[[System.Guid',
                'Id' => '26a4ddb9a4d04519b0ffbc428fb2113e',
                'Number' => 1,
                'Text' => '<div><div>Как с минимальным риском подняться на крышу здания?</div></div>',
                'QuestionMainImg' => '<div><div><img style="width: 300px;" src="/QuestionImages/c35375/26a4ddb9-a4d0-4519-b0ff-bc428fb2113e/8/1.jpg" xmlns:xd="http://schemas.microsoft.com/office/infopath/2003" xd:content-type="png" /></div></div>',
                'answers' => [
                    [
                        "__type" => "<>f__AnonymousType0`2[[System.String, mscorlib],[System.Boolean, mscorlib]], Olimp.Archive",
                        "Text" => "<div><div>Кабель должен быть в кислостойком шланге</div></div>",
                        "Correct" => true
                    ],
                    [
                        "__type" => "<>f__AnonymousType0`2[[System.String, mscorlib],[System.Boolean, mscorlib]], Olimp.Archive",
                        "Text" => "<div><div><div>Кабель должен иметь не более 3 скруток</div></div></div>",
                        "Correct" => false
                    ],
                    [
                        "__type" => "<>f__AnonymousType0`2[[System.String, mscorlib],[System.Boolean, mscorlib]], Olimp.Archive",
                        "Text" => "<div><div>Кабель должен быть только в тканевой оплетке</div></div>",
                        "Correct" => false
                    ],
                    [
                        "__type" => "<>f__AnonymousType0`2[[System.String, mscorlib],[System.Boolean, mscorlib]], Olimp.Archive",
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
