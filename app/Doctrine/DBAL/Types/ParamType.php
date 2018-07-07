<?php

namespace App\Doctrine\DBAL\Types;

use App\ValueObjects\Param;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Exceptions\ValueObjects\InvalidParamException;

class ParamType extends Type
{
    const TYPE_NAME = 'param';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Param
     * @throws InvalidParamException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : Param
    {
        return new Param($value);
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