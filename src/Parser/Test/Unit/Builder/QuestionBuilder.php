<?php

namespace App\Parser\Test\Unit\Builder;

use App\Parser\Entity\Ticket\Question;
use ArrayObject;
use Ramsey\Uuid\Uuid;

class QuestionBuilder
{
    private string $id;
    private string $number;
    private string $text;
    private string $questionMainImg;
    private array $answers;
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->number = '2';
        $this->text = 'Установите соответствие между знаками безопасности и их значениями.';
        $this->questionMainImg = '';
        $this->answers = [];
    }

    public function withId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function withNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }
    public function withText(string $text): self
    {
        $this->text = $text;
        return $this;
    }
    public function withQuestionMainImg(string $questionMainImg): self
    {
        $this->questionMainImg = $questionMainImg;
        return $this;
    }
    public function withAnswers(array $answers): self
    {
        $this->answers = $answers;
        return $this;
    }
    public function build(): Question
    {
        return new Question(
            $this->id,
            $this->number,
            $this->text,
            $this->questionMainImg,
            $this->answers
        );
    }
}
