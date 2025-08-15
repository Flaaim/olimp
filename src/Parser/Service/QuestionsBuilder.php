<?php

namespace App\Parser\Service;

use App\Parser\Entity\Ticket\Question;
use Webmozart\Assert\Assert;

class QuestionsBuilder
{
    private const REQUIRED_FIELDS = [
        'Id',
        'Number',
        'Text',
        'QuestionMainImg'
    ];

    /** @var Question[] */
    private array $questions = [];

    public function __construct(
        private readonly QuestionDataHandler $dataHandler,
        array                                $data
    ) {
        $this->validate($data);
        foreach ($data as $questionData) {
            $this->buildQuestions($questionData);
        }

    }
    private function validate(array $data): void
    {
        Assert::notEmpty($data);
        foreach ($data as $questionData) {
            Assert::isArray($questionData, 'Each question must be an array');

            foreach (self::REQUIRED_FIELDS as $field) {
                Assert::keyExists(
                    $questionData,
                    $field,
                    sprintf('Question is missing required field: %s', $field)
                );
            }
        }
    }
    private function buildQuestions(array $questionData): void
    {
        $this->questions[] = new Question(
            $questionData['Id'],
            $questionData['Number'],
            $this->dataHandler->stripTagsTextField($questionData['Text']),
            $questionData['QuestionMainImg']
        );
    }
    /** @return Question[] */
    public function getArray(): array
    {
        return $this->questions;
    }
}
