<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\ValueObjects\InvalidBadDomainIdException;
use App\ValueObjects\BadDomainId;
use Tests\TestCase;

class BadDomainIdTest extends TestCase
{
    public function testCreateSuccess()
    {
        $id = 'test-uuid';
        
        $instance = new BadDomainId($id);
        
        $this->assertEquals($id, $instance->getId());
    }

    public function testBadDomainIdException()
    {
        $invalidId = 1;

        $this->expectException(InvalidBadDomainIdException::class);

        new BadDomainId($invalidId);
    }
}