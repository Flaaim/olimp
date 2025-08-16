<?php

namespace App\Parser\Service;

use App\Parser\Entity\Parser\Id;
use App\Parser\Entity\Ticket\Ticket;
use ArrayObject;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class QuestionProcessor
{
    private const REQUIRED_FIELDS = [
        'Id',
        'Number',
        'Text',
        'QuestionMainImg'
    ];

    private QuestionsBuilder $builder;
    private QuestionSanitizer $sanitizer;
    public function __construct(QuestionSanitizer $sanitizer, QuestionsBuilder $builder)
    {
        $this->sanitizer = $sanitizer;
        $this->builder = $builder;
    }
    public function createTicket(array $rawQuestions): Ticket
    {
        $this->validate($rawQuestions);
        $sanitized = $this->sanitizer->sanitize($rawQuestions);
        $questions = $this->builder->build($sanitized);

        return new Ticket(
            new Id(Uuid::uuid4()->toString()),
            new ArrayObject($questions)
        );
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
}
