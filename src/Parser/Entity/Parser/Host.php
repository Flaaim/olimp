<?php

namespace App\Parser\Entity\Parser;

use Webmozart\Assert\Assert;

class Host
{
    public const PATH_TO_COURSE = 'Admin/Info/GetTicketInfo/';
    private string $value;

    public function __construct(string $value, HostMapper $mapper)
    {
        Assert::oneOf($value, $mapper->getValue());
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    public function getFullPathToCourse(): string
    {
        return $this->value . self::PATH_TO_COURSE;
    }
}
