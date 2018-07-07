<?php

namespace Tests\Unit\ValueObjects;

use App\Entities\Click;
use App\ValueObjects\ClickId;
use App\ValueObjects\Domain;
use App\ValueObjects\IpAddress;
use App\ValueObjects\Param;
use App\ValueObjects\Referer;
use App\ValueObjects\UserAgent;
use Tests\TestCase;

class ClickTest extends TestCase
{
    public function testCreateSuccess()
    {
        $testData = [
            'id'        => new ClickId('click-uuid'),
            'userAgent' => new UserAgent('User-Agent'),
            'ip'        => new IpAddress('127.0.0.1'),
            'referer'   => new Domain('http://google.com'),
            'param1'    => new Param('param1'),
            'param2'    => new Param('param2')
        ];

        $click = new Click(...array_values($testData));

        $this->assertEquals($testData['id'], $click->getId());
        $this->assertEquals($testData['userAgent'], $click->getUserAgent());
        $this->assertEquals($testData['ip'], $click->getIpAddress());
        $this->assertEquals($testData['referer'], $click->getReferer());
        $this->assertEquals($testData['param1'], $click->getParam1());
        $this->assertEquals($testData['param2'], $click->getParam2());
        $this->assertEquals(0, $click->getErrorsCount());
        $this->assertEquals(false, $click->isBadDomain());
    }
}