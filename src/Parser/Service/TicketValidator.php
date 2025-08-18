<?php

namespace App\Parser\Service;

use Webmozart\Assert\Assert;

class TicketValidator
{
    private const REQUIRED_QUESTION_FIELDS = [
        'Id',
        'Number',
        'Text',
        'QuestionMainImg'
    ];

    private const REQUIRED_ANSWERS_FIELDS = [
        'Text',
        'Correct'
    ];

    public function validate(array $data): void
    {
        Assert::notEmpty($data);
        foreach ($data as $questionData) {
            Assert::isArray($questionData, 'Each question must be an array');
            $this->isCorrectFields($questionData, self::REQUIRED_QUESTION_FIELDS);

            foreach ($questionData['answers'] as $answerData) {
                Assert::isArray($answerData, 'Each answers must be an array');
                $this->isCorrectFields($answerData, self::REQUIRED_ANSWERS_FIELDS);
            }
        }
    }

    private function isCorrectFields(array $data, array $fields): void
    {
        foreach ($fields as $field) {
            Assert::keyExists(
                $data,
                $field,
                sprintf('Question is missing required field: %s', $field)
            );
        }
    }
}
