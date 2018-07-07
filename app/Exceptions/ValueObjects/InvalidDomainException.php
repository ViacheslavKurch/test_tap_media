<?php

namespace App\Exceptions\ValueObjects;

use App\Exceptions\ValidationException;

class InvalidDomainException extends ValidationException
{
    protected $message = 'This bad domain is not valid';
}
