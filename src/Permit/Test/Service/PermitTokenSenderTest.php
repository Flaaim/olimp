<?php

namespace App\Permit\Test\Service;

use App\Frontend\FrontendUrlGenerator;
use App\Permit\Entity\Email;
use App\Permit\Service\PermitTokenSender;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as MimeEmail;

class PermitTokenSenderTest extends TestCase
{
    public function testSuccess(): void
    {
        $to = new Email('user@test.ru');

        $mailer = $this->createMock(MailerInterface::class);
        $frontendUrl = 'http://localhost';
        $url = $frontendUrl . '/some-url-frontend?email=' . $to->getValue();

        $urlGenerator = $this->createMock(FrontendUrlGenerator::class);
        $urlGenerator->expects($this->once())->method('generate')
            ->with(
                $this->equalTo('some-url-frontend'),
                $this->equalTo(['email' => $to->getValue()])
            )->willReturn($url);

        $mailer->expects($this->once())->method('send')->willReturnCallback(static function (MimeEmail $email) use ($to, $url) {
            self::assertEquals(Address::createArray([$to->getValue()]), $email->getTo());
            self::assertEquals('Доступ к билетам с ответами', $email->getSubject());
            self::assertStringContainsString($url, $email->getTextBody());
        });

        $sender = new PermitTokenSender($mailer, $urlGenerator);
        $sender->send($to);
    }

    public function testFailed(): void
    {
        $to = new Email('user@test.ru');
        $mailer = $this->createStub(MailerInterface::class);
        $generator = $this->createMock(FrontendUrlGenerator::class);
        $sender = new PermitTokenSender($mailer, $generator);

        $mailer->method('send')->willThrowException(new TransportException());

        $this->expectException(TransportException::class);
        $sender->send($to);
    }

    private function getFrontendUrlGenerator(): FrontendUrlGenerator
    {
        return new FrontendUrlGenerator('http://localhost');
    }
}
