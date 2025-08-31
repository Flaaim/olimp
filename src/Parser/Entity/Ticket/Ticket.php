<?php

namespace App\Parser\Entity\Ticket;

use App\Parser\Entity\Parser\Id;
use ArrayObject;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tickets')]
final class Ticket
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    private ArrayObject $questions;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cipher = null;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    public function __construct(Id $id, ArrayObject $questions, ?string $cipher = null, ?string $name = null)
    {
        $this->id = $id;
        $this->questions = $questions;
    }
    public function getId(): Id
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getCipher(): ?string
    {
        return $this->cipher;
    }
    public function getQuestions(): array
    {
        return $this->questions->getArrayCopy();
    }

    public static function fromArray(array $data): self
    {
        return new self(
            new Id($data['id']),
            new ArrayObject(array_map(
                fn($questionData): Question => new Question(
                $questionData['id'],
                $questionData['number'],
                $questionData['text'],
                $questionData['image'],
                array_map(
                    fn($answerData): Answer => new Answer(
                        $answerData['text'],
                        $answerData['isCorrect'],
                        $answerData['image']
                    ),
                    $questionData['answers']
                )
            ), $data['questions'])),
            $data['cipher'] ?? null,
            $data['name'] ?? null
        );
    }
}
