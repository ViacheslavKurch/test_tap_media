<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\ValueObjects\InvalidClickIdException;
use App\ValueObjects\ClickId;
use Tests\TestCase;

class ClickIdTest extends TestCase
{
    public function testCreateSuccess()
    {
        $id = 'test-uuid';
        
        $instance = new ClickId($id);
        
        $this->assertEquals($id, $instance->getId());
    }

    public function testClickIdException()
    {
        $invalidId = 1;

        $this->expectException(InvalidClickIdException::class);

        new ClickId($invalidId);
    }
}