<?php

namespace App\Parser\Entity\Parser\GpnParser;

use App\Parser\Entity\Parser\HostMapper;
use Webmozart\Assert\Assert;

class Host
{
    private string $value;
    public const PATH_TO_QUESTIONS = 'Prepare/Content/ShowQuestions';
    public const PATH_TO_CHECK = 'Prepare/Content/CheckQuestion';
    public function __construct(string $value, HostMapper $mapper)
    {
        Assert::oneOf($value, $mapper->getValue());
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getFullPathToQuestions(): string
    {
        return $this->value . self::PATH_TO_QUESTIONS;
    }

    public function getPathToCheckQuestions(): string
    {
        return $this->value . self::PATH_TO_CHECK;
    }
}
