<?php

namespace App\Permit\Command\CreatePayment\Response;

class Response
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $status,
        public readonly ?string $redirectUrl = null,
        public readonly ?string $paymentUrl = null,
    )
    {}
}
