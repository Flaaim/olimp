<?php

namespace App\Shared\Domain\Service\Payment\DTO;

class MakePaymentDTO
{
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $description,
        public readonly array $metadata = [], // Дополнительные данные (order_id, user_id и т.д.)
        public readonly ?string $returnUrl = null, // Куда вернуться после успеха
        public readonly ?string $cancelUrl = null, // Куда вернуться при отмене
        public readonly ?string $customerEmail = null,
    ) {}
}
