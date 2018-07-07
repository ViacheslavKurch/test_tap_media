<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use App\ValueObjects\BadDomainId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Exceptions\ValueObjects\InvalidBadDomainIdException;

class BadDomainIdType extends Type
{
    const TYPE_NAME = 'bad_domain_id';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return BadDomainId
     * @throws InvalidBadDomainIdException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : BadDomainId
    {
        return new BadDomainId($value);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        return $value->getId();
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