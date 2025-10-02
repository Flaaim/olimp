<?php

namespace App\Permit\Command\HookPayment\Request;

use App\Permit\Command\CreateAccess\Request\Command as CreateAccessCommand;
use App\Permit\Command\CreateAccess\Request\Handler as AccessHandler;
use App\Shared\Domain\Service\Payment\DTO\PaymentCallbackDTO;
use App\Shared\Domain\Service\Payment\PaymentProviderInterface;
use App\Shared\Domain\Service\Payment\PaymentStatus;
use App\Shared\Domain\Service\Payment\PaymentWebhookData;
use App\Shared\Domain\Service\Payment\PaymentWebhookParserInterface;


class Handler
{
    public function __construct(
        private readonly AccessHandler              $accessHandler,
        private readonly PaymentWebhookParserInterface       $webhookParser,
        private readonly PaymentProviderInterface $provider,
    )
    {}
    public function handle(Command $command): void
    {
        $data = json_decode($command->requestBody, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON in webhook');
        }

        $callbackDTO = new PaymentCallbackDTO(
            $data,
            $_SERVER['HTTP_CONTENT_SIGNATURE'] ?? '',
            $this->provider->getName()
        );

        $isProcessed = $this->provider->handleCallback($callbackDTO);

        if (!$isProcessed) {
            return;
        }

        if(!$this->webhookParser->supports($callbackDTO->provider, $callbackDTO->rawData)){
            throw new \RuntimeException('Unsupported webhook format');
        }

        $paymentWebHookData = $this->webhookParser->parse($callbackDTO->rawData);

        if($this->shouldCreateAccess($paymentWebHookData)){
            $this->createAccess($paymentWebHookData);
        }
    }

    private function shouldCreateAccess(PaymentWebhookData $webhookData): bool
    {
        return $webhookData->isPaid() &&
                $webhookData->getStatus() === PaymentStatus::SUCCEEDED;
    }
    private function createAccess(PaymentWebhookData $paymentWebHookData): void
    {
        $paymentId = $paymentWebHookData->getMetadata('paymentId');
        $ticketId = $paymentWebHookData->getMetadata('ticketId');
        $email = $paymentWebHookData->getMetadata('email');

        if(!$paymentId || !$ticketId || !$email){
            throw new \InvalidArgumentException('Missing required metadata in webhook');
        }

        $this->accessHandler->handle(
            new CreateAccessCommand($paymentId, $ticketId, $email),
        );
    }
}
