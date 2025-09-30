<?php

namespace App\Permit\Entity\Access;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class AccessStatusType extends StringType
{
    const NAME = 'access_status';
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Status ? $value->getValue() : null;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Status
    {
        return !empty($value) ? new Status((string)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
