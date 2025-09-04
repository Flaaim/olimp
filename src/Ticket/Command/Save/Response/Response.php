<?php

namespace App\Ticket\Command\Save\Response;

use Webmozart\Assert\Assert;

class Response implements \JsonSerializable
{
    public function __construct(
        private string $id,
        private string $name,
        private string $cipher
    ){}
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cipher' => $this->cipher,
        ];
    }
}
