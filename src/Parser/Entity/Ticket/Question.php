<?php

namespace App\Parser\Entity\Ticket;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'questions')]
final class Question
{
    #[ORM\Column(type: 'string', unique: true)]
    private string $id;
    #[ORM\Column(type: 'string', length: 255)]
    private string $number;
    #[ORM\Column(type: 'string', length: 255)]
    private string $text;
    #[ORM\Column(type: 'string', length: 255)]
    private string $questionMainImg;
    private Collection $answers;
    public function __construct(string $id, string $number, string $text, string $questionMainImg, array $answers)
    {
        $this->id = $id;
        $this->number = $number;
        $this->text = $text;
        $this->questionMainImg = $questionMainImg;
        $this->answers = new ArrayCollection($answers);
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getNumber(): string
    {
        return $this->number;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function getQuestionMainImg(): string
    {
        return $this->questionMainImg;
    }
    public function getAnswers(): array
    {
        return $this->answers->toArray();
    }
}
