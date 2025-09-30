<?php

namespace App\Permit\Entity\Payment;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PriceType extends StringType
{
    public const NAME = 'price';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Price ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Price
    {
        return !empty($value) ? new Price((float)$value, new Currency('RUB')) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
