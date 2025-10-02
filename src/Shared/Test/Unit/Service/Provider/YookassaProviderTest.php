<?php

namespace App\Shared\Test\Unit\Service\Provider;

use App\Shared\Domain\Service\Payment\DTO\MakePaymentDTO;
use App\Shared\Domain\Service\Payment\Provider\YookassaConfig;
use App\Shared\Domain\Service\Payment\Provider\YookassaProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use YooKassa\Client;
use YooKassa\Model\Payment\Confirmation\ConfirmationRedirect;
use YooKassa\Request\Payments\CreatePaymentResponse;

class YookassaProviderTest extends TestCase
{

    public function testInitiatePayment(): void
    {
        $paymentDTO = $this->getMakePaymentDTO();
        $paymentId = '22d6d597-000f-5000-9000-145f6df21d6f';
        $status = 'pending';
        $confirmUrl = 'https://test.url';

        $config = $this->getYookassaConfig();

        $confirmationMock = $this->createMock(ConfirmationRedirect::class);
        $confirmationMock->method('getConfirmationUrl')->willReturn($confirmUrl);

        $response = $this->createMock(CreatePaymentResponse::class);

        $response->method('getId')->willReturn($paymentId);
        $response->method('getStatus')->willReturn($status);
        $response->method('getConfirmation')->willReturn($confirmationMock);

        $client = $this->createMock(Client::class);
        $client->expects($this->once())->method('createPayment')->with(
            $this->equalTo([
                'amount' => [
                    'value' => $paymentDTO->amount,
                    'currency' => $paymentDTO->currency,
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'locale' => 'ru_RU',
                    'return_url' => $config->getReturnUrl(),
                ],
                'capture' => true,
                'description' => $paymentDTO->description,
                'metadata' => $paymentDTO->metadata,
                'receipt' => [
                    'customer' => [
                        'email' => $paymentDTO->customerEmail,
                    ]
                ]
            ]),
            $this->isType('string')
        )->willReturn($response);

        $provider = new YookassaProvider(
            $client,
            $config,
        );

        $payment = $provider->initiatePayment($paymentDTO);
        $this->assertEquals($paymentId, $payment->paymentId);
        $this->assertEquals($status, $payment->status);
        $this->assertEquals($confirmUrl, $payment->redirectUrl);
    }
    public function testGetName(): void
    {
        $provider = new YookassaProvider(
            $this->getClient(),
            $this->getYookassaConfig()
        );

        $name = $provider->getName();
        $this->assertEquals('Yookassa', $name);
    }

    private function getYookassaConfig(): YookassaConfig
    {
        $config = [
            'name' => 'Yookassa',
            'shopId' => '221345',
            'secretKey' => 'test_0B3flJqsbdKNA2sS2dT0ahs74LtF7fwJq2oVR-8wTCM',
            'returnUrl' => 'http://localhost:8080/payment/success',
        ];
        return new YookassaConfig(
            $config['name'], $config['shopId'], $config['secretKey'], $config['returnUrl']
        );
    }
    private function getClient(): Client
    {
        return $this->createMock(Client::class);
    }

    private function getMakePaymentDTO(): MakePaymentDTO
    {
        return new MakePaymentDTO(
            250.00,
            'RUB',
            'Оплата доступа к ответам на курс',
            [
                'email' => 'user@app.ru',
                'ticketId' => Uuid::uuid4()->toString(),
                'paymentId' => Uuid::uuid4()->toString(),
            ],
            'user@app.ru'
        );
    }
}
