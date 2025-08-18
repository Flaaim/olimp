<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Entity\Parser\Host;
use App\Parser\Entity\Parser\HostMapper;
use App\Parser\Service\TicketSanitizer;
use PHPUnit\Framework\TestCase;

class QuestionSanitizerTest extends TestCase
{
    public function testSuccess(): void
    {
        $sanitized = (new TicketSanitizer($this->getHost()))->sanitize($this->getQuestionsWithTags());

        $this->assertEquals($this->getSanitizedQuestions(), $sanitized);
    }

    public function testGetImagePath(): void
    {
        $sanitized = (new TicketSanitizer($this->getHost()))->sanitize($this->getQuestionsWithTags());

        $this->assertEquals($this->getSanitizedQuestions(), $sanitized);
    }

    private function getQuestionsWithTags(): array
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

    private function getSanitizedQuestions(): array
    {
        return [
            array(
                '__type' => 'f__AnonymousType12`4[[System.Guid',
                'Id' => '26a4ddb9a4d04519b0ffbc428fb2113e',
                'Number' => 1,
                'Text' => 'Как с минимальным риском подняться на крышу здания?',
                'QuestionMainImg' => $this->getHost()->getValue().'QuestionImages/c35375/26a4ddb9-a4d0-4519-b0ff-bc428fb2113e/8/1.jpg'
            )
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
