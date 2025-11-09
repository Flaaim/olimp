<?php

namespace App\Parser\Service\Interface;

interface TicketImageHandler
{
    public function handle(array $rawQuestions): array;
}
