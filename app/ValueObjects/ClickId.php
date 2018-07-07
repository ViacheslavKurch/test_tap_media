<?php

namespace App\ValueObjects;

use App\Exceptions\ValueObjects\InvalidClickIdException;

class ClickId
{
    /**
     * @var string
     */
    private $id;

    /**
     * ClickId constructor.
     * @param null $id
     * @throws InvalidClickIdException
     */
    public function __construct($id = null)
    {
        $this->validate($id);
        $this->id = $id ?? UUID::generate();
    }

    /**
     * @param $value
     * @throws InvalidClickIdException
     */
    private function validate($value)
    {
        if (null !== $value && (!is_string($value) || empty($value))) {
            throw new InvalidClickIdException();
        }
    }

    /**
     * @return null|string
     */
    public function getId() : ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->id;
    }
}