<?php

namespace App\Shared\Domain\Service\Payment\DTO;

class PaymentCallbackDTO
{
    public function __construct(
        public readonly array $rawData,
        public readonly string $signature,
        public readonly string $provider,
    ) {}
}
