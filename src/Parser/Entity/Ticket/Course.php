<?php

namespace App\Parser\Entity\Ticket;

use App\Shared\Domain\ValueObject\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'courses')]
class Course
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;
    #[ORM\Column(type: 'string', length: 255)]
    private string $description;
    #[ORM\OneToOne(targetEntity: Ticket::class, mappedBy: 'course')]
    private ?Ticket $ticket = null;

    public function __construct(Id $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
    public function getId(): Id
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }
    public function setTicket(?Ticket $ticket): self
    {
        if ($ticket === null && $this->ticket !== null) {
            $this->ticket->setCourse(null);
        }

        if ($ticket !== null && $ticket->getCourse() !== $this) {
            $ticket->setCourse($this);
        }

        $this->ticket = $ticket;
        return $this;
    }
}
