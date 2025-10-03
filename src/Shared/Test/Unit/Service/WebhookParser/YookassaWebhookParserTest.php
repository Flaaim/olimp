<?php

namespace App\Shared\Test\Unit\Service\WebhookParser;

use App\Shared\Domain\Service\Payment\WebhookParser\YookassaWebhookParser;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;


class YookassaWebhookParserTest extends TestCase
{
    public function testSupportSuccess(): void
    {
        $name = 'Yookassa';
        $data = [
            'status' => 'succeeded',
            'paymentId' => Uuid::uuid4()->toString(),
            'amount' => 150.00,
            'currency' => 'RUB',
            'metadata' => ['email' => 'user@app.ru', 'ticketId' => Uuid::uuid4()->toString()],
        ];
        $parser = new YookassaWebhookParser();
        $this->assertTrue($parser->supports($name, $data));
    }
    public function testSupportEmpty(): void
    {
        $name = '';
        $data = [];
        $parser = new YookassaWebhookParser();
        $this->assertFalse($parser->supports($name, $data));
    }
    public function testSupportInvalidName(): void
    {
        $name = 'Tinkoff';
        $data = [
            'status' => 'succeeded',
            'paymentId' => Uuid::uuid4()->toString(),
            'amount' => 150.00,
            'currency' => 'RUB',
            'metadata' => ['email' => 'user@app.ru', 'ticketId' => Uuid::uuid4()->toString()]
        ];
        $parser = new YookassaWebhookParser();
        $this->assertFalse($parser->supports($name, $data));
    }
    public function testSupportInvalidData(): void
    {
        $name = 'Yookassa';
        $data = [
            'status' => 'succeeded',
            'payment' => Uuid::uuid4()->toString(),
            'amount' => 150.00,
            'currency' => 'RUB',
            'metadata' => ['email' => 'user@app.ru', 'ticketId' => Uuid::uuid4()->toString()],
        ];
        $parser = new YookassaWebhookParser();
        $this->assertFalse($parser->supports($name, $data));
    }
    public function testParseSuccess(): void
    {
        $data = [
            'status' => 'succeeded',
            'paymentId' => Uuid::uuid4()->toString(),
            'amount' => 150.00,
            'currency' => 'RUB',
            'metadata' => ['email' => 'user@app.ru', 'ticketId' => Uuid::uuid4()->toString()],
        ];
        $parser = new YookassaWebhookParser();
        $webhookData = $parser->parse($data);
        $this->assertEquals($data['status'], $webhookData->getStatus());
        $this->assertEquals($data['paymentId'], $webhookData->getPaymentId());
        $this->assertEquals($data['amount'], $webhookData->getAmount());
        $this->assertEquals($data['currency'], $webhookData->getCurrency());
        $this->assertEquals($data['metadata']['email'], $webhookData->getMetadata('email'));
        $this->assertEquals($data['metadata']['ticketId'], $webhookData->getMetadata('ticketId'));

    }

    public function testParseEmpty(): void
    {
        $parser = new YookassaWebhookParser();
        $this->expectException(\InvalidArgumentException::class);
        $parser->parse([]);
    }
    public function testParseInvalidData(): void
    {
        $data = [
            'status' => 'succeeded',
            'payment' => Uuid::uuid4()->toString(),
            'amount' => 150.00,
            'currency' => 'RUB',
            'metadata' => ['email' => 'user@app.ru', 'ticketId' => Uuid::uuid4()->toString()],
        ];
        $parser = new YookassaWebhookParser();
        $this->expectException(\InvalidArgumentException::class);
        $parser->parse($data);
    }

}
