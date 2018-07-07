<?php

namespace App\ValueObjects;

use App\Exceptions\ValueObjects\InvalidBadDomainIdException;

class BadDomainId
{
    /**
     * @var string
     */
    private $id;

    /**
     * BadDomainId constructor.
     * @param null $id
     * @throws InvalidBadDomainIdException
     */
    public function __construct($id = null)
    {
        $this->validate($id);
        $this->id = $id ?? UUID::generate();
    }

    /**
     * @param $value
     * @throws InvalidBadDomainIdException
     */
    private function validate($value)
    {
        if (null !== $value && (!is_string($value) || empty($value))) {
            throw new InvalidBadDomainIdException();
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