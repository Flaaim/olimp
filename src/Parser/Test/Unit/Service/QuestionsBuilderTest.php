<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Service\QuestionDataHandler;
use App\Parser\Service\QuestionsBuilder;
use PHPUnit\Framework\TestCase;

class QuestionsBuilderTest extends TestCase
{

    public function testSuccess(): void
    {
        $builder = new QuestionsBuilder(
            $this->getQuestionDataHandler(),
            $this->getValidQuestions()
        );

        $this->assertNotNull($builder->getArray());

        $this->assertEquals($this->getValidQuestions()[0]['Id'], $builder->getArray()[0]->getId());
        $this->assertEquals($this->getValidQuestions()[0]['Number'], $builder->getArray()[0]->getNumber());
        $this->assertEquals(
            $this->getQuestionDataHandler()->stripTagsTextField($this->getValidQuestions()[0]['Text']),
            $builder->getArray()[0]->getText()
        );
        $this->assertEquals($this->getValidQuestions()[0]['QuestionMainImg'], $builder->getArray()[0]->getQuestionMainImg());

    }

    public function testStripsTagsFromText(): void
    {
        $builder = new QuestionsBuilder(
            $this->getQuestionDataHandler(),
            $this->getValidQuestions()
        );

        $this->assertStringNotContainsString('<div>', $builder->getArray()[0]->getText());
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new QuestionsBuilder($this->getQuestionDataHandler(), []);
    }

    public function testKeyNotExists(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new QuestionsBuilder($this->getQuestionDataHandler(), $this->getInvalidQuestions());

    }

    private function getQuestionDataHandler(): QuestionDataHandler
    {
        return new QuestionDataHandler();
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
                'Number' => 1,
                'Text' => '<div><div>Как с минимальным риском подняться на крышу здания?</div></div>',
                'QuestionMainImg' => '<div><div><img style="width: 300px;" src="/QuestionImages/c35375/26a4ddb9-a4d0-4519-b0ff-bc428fb2113e/8/1.jpg" xmlns:xd="http://schemas.microsoft.com/office/infopath/2003" xd:content-type="png" /></div></div>'
            ]
        ];
    }
}
