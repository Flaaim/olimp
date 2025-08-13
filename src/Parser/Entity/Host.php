<?php

namespace App\Parser\Entity;

use Webmozart\Assert\Assert;

class Host
{
    public const HOST_PRK = 'http://prk.kuzstu.ru:9001/Admin/Info/GetTicketInfo';
    public const HOST_CHUKK = 'http://olimpoks.chukk.ru:82/Admin/Info/GetTicketInfo';
    private string $value;

    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::HOST_PRK,
            self::HOST_CHUKK
        ]);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    public static function prk(): self
    {
        return new self(self::HOST_PRK);
    }
    public static function chukk(): self
    {
        return new self(self::HOST_CHUKK);
    }
}
