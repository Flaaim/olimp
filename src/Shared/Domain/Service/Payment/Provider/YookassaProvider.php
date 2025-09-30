<?php

namespace App\Shared\Domain\Service\Payment\Provider;

use App\Shared\Domain\Service\Payment\DTO\MakePaymentDTO;
use App\Shared\Domain\Service\Payment\DTO\PaymentCallbackDTO;
use App\Shared\Domain\Service\Payment\DTO\PaymentInfoDTO;
use App\Shared\Domain\Service\Payment\PaymentProviderInterface;

class YookassaProvider implements PaymentProviderInterface
{

    public function initiatePayment(MakePaymentDTO $paymentData): PaymentInfoDTO
    {
        // TODO: Implement initiatePayment() method.
    }

    public function handleCallback(PaymentCallbackDTO $callbackData): bool
    {
        // TODO: Implement handleCallback() method.
    }

    public function checkPaymentStatus(string $paymentId): string
    {
        // TODO: Implement checkPaymentStatus() method.
    }

    public function getSupportedCurrencies(): array
    {
        // TODO: Implement getSupportedCurrencies() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }
}
