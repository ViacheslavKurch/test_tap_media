<?php

namespace App\Exceptions;

class BadDomainExistsException extends \Exception
{
    protected $message = 'This bad domain already exists';
}