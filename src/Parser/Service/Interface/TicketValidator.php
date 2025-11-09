<?php

namespace App\Parser\Service\Interface;

interface TicketValidator
{
    public function validate(array $data): void;
}
