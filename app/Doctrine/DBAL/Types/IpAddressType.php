<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use App\ValueObjects\IpAddress;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Exceptions\ValueObjects\InvalidIpAddressException;

class IpAddressType extends Type
{
    const TYPE_NAME = 'ip_address';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return IpAddress
     * @throws InvalidIpAddressException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : IpAddress
    {
        return new IpAddress($value);
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

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {}
}