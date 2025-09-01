<?php

namespace App\Ticket\Command\Save\Response;

class Response
{
    public function __construct(
        private string $id,
        private string $name,
        private string $cipher
    ){}
}
