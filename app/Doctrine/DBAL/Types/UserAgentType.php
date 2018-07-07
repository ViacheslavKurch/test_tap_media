<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use App\ValueObjects\UserAgent;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Exceptions\ValueObjects\InvalidUserAgentException;

class UserAgentType extends Type
{
    const TYPE_NAME = 'user_agent';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return UserAgent
     * @throws InvalidUserAgentException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : UserAgent
    {
        return new UserAgent($value);
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
    public function getName()
    {
        return self::TYPE_NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {}
}