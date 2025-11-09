<?php

namespace App\Parser\Service\Interface;

interface TicketSanitizer
{
    public function sanitize(array $rawQuestions): array;
}
