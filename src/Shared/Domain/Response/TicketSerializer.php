<?php

namespace App\Shared\Domain\Response;

interface TicketSerializer
{
    public function serialize(TicketResponse $response): string;
}
