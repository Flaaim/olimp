<?php

namespace App\Permit\Entity;

use App\Frontend\FrontendUrlGenerator;
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
    public function send(Email $email): void
    {
        $message = (new \Symfony\Component\Mime\Email())
            ->subject('Доступ к билетам с ответами')
            ->to($email->getValue())
            ->text($this->frontendUrl->generate(
                'some-url-frontend',
                    ['email' => $email->getValue()]
                )
            );
        try {
            $this->mailer->send($message);
        }catch (TransportExceptionInterface $e) {
            throw new TransportException($e->getMessage());
        }
    }
}
