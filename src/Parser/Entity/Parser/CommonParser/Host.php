<?php

namespace App\Parser\Entity\Parser\CommonParser;

use App\Parser\Entity\Parser\HostMapper;
use Webmozart\Assert\Assert;

class Host
{
    public const PATH_TO_TICKET = 'Admin/Info/GetTicketInfo/';
    public const PATH_TO_ANSWERS = 'Admin/Archive/QuestionInfo';
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
    public function getFullPathToTicket(): string
    {
        return $this->value . self::PATH_TO_TICKET;
    }
    public function getFullPathToAnswers(): string
    {
        return $this->value . self::PATH_TO_ANSWERS;
    }
}
