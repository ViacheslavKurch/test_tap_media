<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\ValueObjects\InvalidClickIdException;
use App\Exceptions\ValueObjects\InvalidDomainException;
use App\ValueObjects\ClickId;
use App\ValueObjects\Domain;
use Tests\TestCase;

class DomainTest extends TestCase
{
    public function testCreateSuccess()
    {
        $domain = 'http://domain.com';
        
        $instance = new Domain($domain);
        
        $this->assertEquals($domain, $instance->getValue());
    }

    public function testDomainException()
    {
        $invalidDomain = 'domain';

        $this->expectException(InvalidDomainException::class);

        new Domain($invalidDomain);
    }
}