<?php

namespace App\Permit\Entity\Payment;

interface PaymentRepository
{
    public function create(Payment $payment);
}
