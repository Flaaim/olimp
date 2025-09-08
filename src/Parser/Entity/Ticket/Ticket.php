<?php

namespace App\Parser\Entity\Ticket;

use App\Parser\Entity\Parser\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tickets')]
final class Ticket
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'ticket', cascade: ['persist'], orphanRemoval: true)]
    private Collection $questions;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cipher;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name;
    private function __construct(Id $id, ?string $cipher = null, ?string $name = null)
    {
        $this->id = $id;
        $this->cipher = $cipher;
        $this->name = $name;
        $this->questions = new ArrayCollection();
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
    public function getQuestions(): Collection
    {
        return $this->questions;
    }
    public static function fromArray(array $data): self
    {
       $ticket = new self(
            new Id($data['id']),
            $data['cipher'],
            $data['name']
       );

        if(!empty($data['questions'])){
            foreach ($data['questions'] as $questionData){
                $question = Question::fromArray($questionData);
                $ticket->addQuestions($question);
            }
        }

        return $ticket;
    }
    public function addQuestions(Question $question): self
    {
        $this->questions->add($question);
        $question->setTicket($this);
        return $this;
    }
    public function updateQuestionImagesUrl(string $questionId, string $newUrl): void
    {
        foreach ($this->questions->toArray() as $question){
            if($question->getId() === $questionId){
                $question->setQuestionMainImg($newUrl);
                return;
            }
        }
        throw new \RuntimeException("Question with ID $questionId not found");

    }
}
