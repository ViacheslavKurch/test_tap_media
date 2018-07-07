<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\IBadDomainRepository;
use App\Contracts\Repositories\IClickRepository;
use App\Entities\Click;
use App\Exceptions\ClickNotFoundException;
use App\Exceptions\MethodNotAllowedException;
use App\Services\ClickService;
use App\Services\ResponseService;
use App\ValueObjects\ClickId;
use App\ValueObjects\Domain;
use App\ValueObjects\IpAddress;
use App\ValueObjects\Param;
use App\ValueObjects\Referer;
use App\ValueObjects\UserAgent;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ResponseServiceTest extends TestCase
{
    /**
     * @var IClickRepository | MockObject
     */
    private $clickRepository;

    /**
     * @var ResponseService
     */
    private $service;

    public function setUp()
    {
        $this->clickRepository = $this->getMockBuilder(IClickRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new ResponseService(
            $this->clickRepository
        );
    }

    public function testFindClickNotFoundException()
    {
        $clickId = new ClickId('click-uuid');

        $this->clickRepository
            ->method('get')
            ->willThrowException(new ClickNotFoundException());

        $this->expectException(ClickNotFoundException::class);

        $this->service->getSuccessData($clickId);
    }

    public function testGetSuccessData()
    {
        $testData = $this->getTestData();

        $click = new Click(...array_values($testData));

        $this->assertEquals(0, $click->getErrorsCount());
        $this->assertEquals(false, $click->isBadDomain());

        $this->clickRepository
            ->method('get')
            ->with($testData['id'])
            ->willReturn($click);

        $this->assertEquals($click, $this->service->getSuccessData($testData['id']));
    }

    public function testGetSuccessDataMethodNotAllowedException()
    {
        $testData = $this->getTestData();

        $click = new Click(...array_values($testData));

        $click->incrementErrorsCount();

        $this->assertEquals(1, $click->getErrorsCount());
        $this->assertEquals(false, $click->isBadDomain());

        $this->clickRepository
            ->method('get')
            ->with($testData['id'])
            ->willThrowException(new MethodNotAllowedException());

        $this->expectException(MethodNotAllowedException::class);

        $this->service->getSuccessData($testData['id']);
    }

    public function testGetErrorData()
    {
        $testData = $this->getTestData();

        $click = new Click(...array_values($testData));

        $click->incrementErrorsCount(1);

        $this->assertEquals(1, $click->getErrorsCount());
        $this->assertEquals(false, $click->isBadDomain());

        $this->clickRepository
            ->method('get')
            ->with($testData['id'])
            ->willReturn($click);

        $this->assertEquals($click, $this->service->getErrorData($testData['id']));
    }

    public function testGetErrorDataMethodNotAllowedException()
    {
        $testData = $this->getTestData();

        $click = new Click(...array_values($testData));

        $this->assertEquals(0, $click->getErrorsCount());
        $this->assertEquals(false, $click->isBadDomain());

        $this->clickRepository
            ->method('get')
            ->with($testData['id'])
            ->willReturn($click);

        $this->expectException(MethodNotAllowedException::class);

        $this->service->getErrorData($testData['id']);
    }

    public function getTestData()
    {
        return [
            'id'        => new ClickId('click-uuid'),
            'userAgent' => new UserAgent('User-Agent'),
            'ip'        => new IpAddress('127.0.0.1'),
            'referer'   => new Domain('http://google.com'),
            'param1'    => new Param('param1'),
            'param2'    => new Param('param2')
        ];
    }
}