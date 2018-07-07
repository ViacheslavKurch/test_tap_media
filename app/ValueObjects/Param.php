<?php

namespace App\ValueObjects;

use App\Exceptions\ValueObjects\InvalidParamException;

class Param
{
    /**
     * @var string
     */
    private $value;

    /**
     * Param constructor.
     * @param $value
     * @throws InvalidParamException
     */
    public function __construct($value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @param $value
     * @throws InvalidParamException
     */
    private function validate($value)
    {
        if (!(!empty($value) && is_string($value))) {
            throw new InvalidParamException();
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