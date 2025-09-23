<?php

namespace App\Parser\Entity\Ticket;

use App\Parser\Entity\Parser\Id;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

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
    #[ORM\Column(type: 'status')]
    private Status $status;
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt;
    private function __construct(Id $id, ?string $cipher = null, ?string $name = null, DateTimeImmutable $updatedAt = null)
    {
        $this->id = $id;
        $this->cipher = $cipher;
        $this->name = $name;
        $this->status = Status::deactivated();
        $this->updatedAt = $updatedAt;
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
    public function getStatus(): Status
    {
        return $this->status;
    }
    public static function fromArray(array $data): self
    {
       $ticket = new self(
            new Id($data['id']),
            $data['cipher'],
            $data['name'],
            $data['updatedAt']
       );

        if(!empty($data['status'])){
            $ticket->setStatus(new Status($data['status']));
        }

        if(!empty($data['questions'])){
            foreach ($data['questions'] as $questionData){
                $question = Question::fromArray($questionData);
                $ticket->addQuestions($question);
            }
        }

        return $ticket;
    }
    public function setStatus(Status $status): void
    {
        $this->status = $status;
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
            /** @var Question $question */
            if($question->getId() === $questionId){
                /** @var Question $question */
                $question->setQuestionMainImg($newUrl);
                return;
            }
        }
        throw new \RuntimeException("Question with ID $questionId not found");
    }
    public function updateAnswerImagesUrl(string $answerId, string $newUrl): void
    {
        /** @var Question $question */
        foreach ($this->questions->toArray() as $question){
            /** @var Answer $answer */
            foreach ($question->getAnswers()->toArray() as $answer){
                if($answer->getId()->getValue() === $answerId){
                    $answer->setAnswerImg($newUrl);
                    return;
                }
            }
        }
        throw new \RuntimeException("Answer with ID $answerId not found");
    }
    public function updateFrom(self $newTicket): self
    {
        $this->name = $newTicket->getName();
        $this->cipher = $newTicket->getCipher();
        $this->status = $newTicket->getStatus();

        return $this;
    }
}
