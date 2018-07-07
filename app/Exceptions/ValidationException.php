<?php

namespace App\Exceptions;

class ValidationException extends \Exception
{
    protected $message = 'This field is not valid';
}
