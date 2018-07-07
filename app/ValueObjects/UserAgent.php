<?php

namespace App\ValueObjects;

use App\Exceptions\ValueObjects\InvalidUserAgentException;

class UserAgent
{
    /**
     * @var string
     */
    private $value;

    /**
     * UserAgent constructor.
     * @param string $value
     * @throws InvalidUserAgentException
     */
    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @param $value
     * @throws InvalidUserAgentException
     */
    private function validate($value)
    {
        if (!is_string($value) || empty($value)) {
            throw new InvalidUserAgentException();
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