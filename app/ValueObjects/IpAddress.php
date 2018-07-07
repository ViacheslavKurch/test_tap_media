<?php

namespace App\ValueObjects;

use App\Exceptions\ValueObjects\InvalidIpAddressException;

class IpAddress
{
    /**
     * @var string
     */
    private $value;

    /**
     * IpAddress constructor.
     * @param $value
     * @throws InvalidIpAddressException
     */
    public function __construct($value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @param $value
     * @throws InvalidIpAddressException
     */
    private function validate($value)
    {
        if (filter_var($value, FILTER_VALIDATE_IP) === false) {
            throw new InvalidIpAddressException();
        }
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->value;
    }
}