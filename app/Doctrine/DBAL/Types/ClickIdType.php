<?php

namespace App\Doctrine\DBAL\Types;

use App\ValueObjects\ClickId;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Exceptions\ValueObjects\InvalidClickIdException;

class ClickIdType extends Type
{
    const TYPE_NAME = 'click_id';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return ClickId
     * @throws InvalidClickIdException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : ClickId
    {
        return new ClickId($value);
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