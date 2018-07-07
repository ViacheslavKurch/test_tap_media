<?php

namespace App\Doctrine\DBAL\Types;

use App\ValueObjects\Domain;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Exceptions\ValueObjects\InvalidDomainException;

class DomainType extends Type
{
    const TYPE_NAME = 'domain';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Domain
     * @throws InvalidDomainException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : Domain
    {
        return new Domain($value);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        return $value->getValue();
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return self::TYPE_NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform){}
}