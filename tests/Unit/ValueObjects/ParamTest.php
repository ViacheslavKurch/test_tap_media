<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\ValueObjects\InvalidParamException;
use App\ValueObjects\Param;
use Tests\TestCase;

class ParamTest extends TestCase
{
    public function testCreateSuccess()
    {
        $requestParam = 'param';
        
        $instance = new Param($requestParam);
        
        $this->assertEquals($requestParam, $instance->getValue());
    }

    public function testIpAddressException()
    {
        $emptyRequestParam = '';

        $this->expectException(InvalidParamException::class);

        new Param($emptyRequestParam);
    }
}