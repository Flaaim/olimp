<?php

namespace App\Shared\Domain\Service\Payment\DTO;

class PaymentInfoDTO
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $status,
        public readonly ?string $redirectUrl = null, // Для перенаправления на шлюз
        public readonly ?array $paymentData = null, // Дополнительные данные провайдера
    ) {}
}
