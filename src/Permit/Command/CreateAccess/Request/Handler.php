<?php

namespace App\Permit\Command\CreateAccess\Request;

use App\Flusher;
use App\Permit\Entity\Access\Access;
use App\Permit\Entity\Access\AccessRepository;
use App\Permit\Entity\Access\Status;
use App\Permit\Entity\Email;
use App\Permit\Entity\Token;
use App\Permit\Service\PermitTokenSender;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Handler
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly AccessRepository $accesses,
        private readonly PermitTokenSender $sender
    )
    {}
    public function handle(Command $command): void
    {
        $token = new Token(
            Uuid::uuid4()->toString(),
            new DateTimeImmutable('+ 1 day')
        );

        $access = new Access(
            $token,
            $email = new Email($command->email),
            $command->ticketId,
            $command->paymentId,
            Status::active(),
            new DateTimeImmutable()
        );

        $this->accesses->create($access);

        $this->sender->send($email, $token, $command->ticketId);

        $this->flusher->flush();
    }
}
