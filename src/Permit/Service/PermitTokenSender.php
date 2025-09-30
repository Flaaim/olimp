<?php

namespace App\Permit\Service;

use App\Frontend\FrontendUrlGenerator;
use App\Parser\Entity\Ticket\Ticket;
use App\Permit\Entity\Email;
use App\Permit\Entity\Token;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class PermitTokenSender
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly FrontendUrlGenerator $frontendUrl
    )
    {}
    public function send(Email $email, Token $token, string $ticketId): void
    {
        $message = (new \Symfony\Component\Mime\Email())
            ->subject('Доступ к билетам с ответами')
            ->to($email->getValue())
            ->text($this->frontendUrl->generate(
                '/access',
                    ['ticketId' => $ticketId, 'token' => $token->getValue()]
                )
            );
        try {
            $this->mailer->send($message);
        }catch (TransportExceptionInterface $e) {
            throw new TransportException($e->getMessage());
        }
    }
}
