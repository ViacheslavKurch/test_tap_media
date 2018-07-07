<?php

namespace Tests\Unit\ValueObjects;

use App\Entities\BadDomain;
use App\ValueObjects\BadDomainId;
use App\ValueObjects\Domain;
use Tests\TestCase;

class BadDomainTest extends TestCase
{
    public function testCreateSuccess()
    {
        $testData = [
            'id'     => new BadDomainId('test-uuid'),
            'domain' => new Domain('http://google.com')
        ];

        $badDomain = new BadDomain($testData['id'], $testData['domain']);

        $this->assertEquals($testData['id'], $badDomain->getId());
        $this->assertEquals($testData['domain'], $badDomain->getDomain());
    }
}