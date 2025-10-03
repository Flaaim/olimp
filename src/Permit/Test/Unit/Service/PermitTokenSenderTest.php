<?php

namespace App\Permit\Test\Unit\Service;

use App\Frontend\FrontendUrlGenerator;
use App\Permit\Entity\Email;
use App\Permit\Entity\Token;
use App\Permit\Service\PermitTokenSender;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as MimeEmail;

class PermitTokenSenderTest extends TestCase
{
    public function testSuccess(): void
    {
        $to = new Email('user@test.ru');
        $token = $this->getToken();
        $ticketId = Uuid::uuid4()->toString();

        $mailer = $this->createMock(MailerInterface::class);
        $frontendUrl = 'http://localhost';
        $url = $frontendUrl . '/access?ticketId=' . $ticketId . '&token=' . $token->getValue();

        $urlGenerator = $this->createMock(FrontendUrlGenerator::class);
        $urlGenerator->expects($this->once())->method('generate')
            ->with(
                $this->equalTo('access'),
                $this->equalTo(['ticketId' => $ticketId, 'token' => $token->getValue()])
            )->willReturn($url);

        $mailer->expects($this->once())->method('send')->willReturnCallback(static function (MimeEmail $email) use ($to, $url) {
            self::assertEquals(Address::createArray([$to->getValue()]), $email->getTo());
            self::assertEquals('Доступ к билетам с ответами', $email->getSubject());
            self::assertStringContainsString($url, $email->getTextBody());
        });

        $sender = new PermitTokenSender($mailer, $urlGenerator);
        $sender->send($to, $token, $ticketId);
    }

    public function testFailed(): void
    {
        $to = new Email('user@test.ru');
        $token = $this->getToken();
        $ticketId = Uuid::uuid4()->toString();

        $mailer = $this->createStub(MailerInterface::class);
        $generator = $this->createMock(FrontendUrlGenerator::class);
        $sender = new PermitTokenSender($mailer, $generator);

        $mailer->method('send')->willThrowException(new TransportException());

        $this->expectException(TransportException::class);
        $sender->send($to, $token, $ticketId);
    }
    private function getToken(): Token
    {
        return new Token(
            new Id(Uuid::uuid4()->toString()),
            new DateTimeImmutable('+ 1 day'),
        );
    }
}
