<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\ValueObjects\InvalidClickIdException;
use App\Exceptions\ValueObjects\InvalidDomainException;
use App\Exceptions\ValueObjects\InvalidIpAddressException;
use App\ValueObjects\ClickId;
use App\ValueObjects\Domain;
use App\ValueObjects\IpAddress;
use Tests\TestCase;

class IpAddressTest extends TestCase
{
    public function testCreateSuccess()
    {
        $ipAddress = '127.0.0.1';
        
        $instance = new IpAddress($ipAddress);
        
        $this->assertEquals($ipAddress, $instance->getValue());
    }

    public function testIpAddressException()
    {
        $invalidIpAddress = 888;

        $this->expectException(InvalidIpAddressException::class);

        new IpAddress($invalidIpAddress);
    }
}