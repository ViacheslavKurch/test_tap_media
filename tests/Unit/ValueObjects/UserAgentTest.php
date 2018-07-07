<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\ValueObjects\InvalidUserAgentException;
use App\ValueObjects\UserAgent;
use Tests\TestCase;

class UserAgentTest extends TestCase
{
    public function testCreateSuccess()
    {
        $userAgent = 'User-Agent';
        
        $instance = new UserAgent($userAgent);
        
        $this->assertEquals($userAgent, $instance->getValue());
    }

    public function testUserAgentException()
    {
        $invalidUserAgent = '';

        $this->expectException(InvalidUserAgentException::class);

        new UserAgent($invalidUserAgent);
    }
}