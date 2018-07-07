<?php

namespace App\ValueObjects;

use Ramsey\Uuid\Uuid as IdGenerator;

class UUID
{
    public static function generate() : string
    {
        return IdGenerator::uuid1()->toString();
    }
}