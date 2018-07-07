<?php

namespace App\ValueObjects;

use App\Exceptions\ValueObjects\InvalidDomainException;

class Domain
{
    /**
     * @var string
     */
    private $value;

    /**
     * Domain constructor.
     * @param $value
     * @throws InvalidDomainException
     */
    public function __construct($value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @param $value
     * @throws InvalidDomainException
     */
    private function validate($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new InvalidDomainException();
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