<?php

namespace App\Parser\Entity\Ticket;

use App\Permit\Entity\Payment\Currency;
use App\Permit\Entity\Payment\Price;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

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
    #[ORM\Column(type: 'ticket_status')]
    private Status $status;
    #[ORM\Column(type: 'price', nullable: true)]
    private ?Price $price = null;
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $updatedAt;
    public function __construct(Id $id, ?string $cipher = null, ?string $name = null, DateTimeImmutable $updatedAt = null)
    {
        $this->id = $id;
        $this->cipher = $cipher;
        $this->name = $name;
        $this->status = Status::nonactive();
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
    public function getPrice(): ?Price
    {
        return $this->price;
    }
    public static function fromArray(array $data): self
    {
       $ticket = new self(
            new Id($data['id']),
            $data['cipher'],
            $data['name'],
            $data['updatedAt'] ?? null
       );

       if(isset($data['price']) && $data['price'] instanceof Price) {
           $ticket->setPrice($data['price']);
       }

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
    public function setStatus(Status $newStatus): void
    {
        if($this->status->getValue() !== $newStatus->getValue()){
            $this->status = $newStatus;
        }
    }
    public function setActive(): void
    {
        if(!$this->hasPrice()){
            throw new DomainException('Cannot activate ticket without price');
        }
        if ($this->price->getValue() <= 0) {
            throw new DomainException('Cannot activate ticket with zero or negative price');
        }
        if($this->status->getValue() === Status::active()->getValue()){
            throw new DomainException('Cannot activate ticket with active status');
        }
        $this->status = Status::active();
    }
    public function setPrice(Price $newPrice): void
    {
        if($this->price === null || $this->price->equals($newPrice)){
            $this->price = $newPrice;
        }
    }
    public function hasPrice(): bool
    {
        return $this->price !== null;
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
