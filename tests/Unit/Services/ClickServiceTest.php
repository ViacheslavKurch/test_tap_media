<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\IBadDomainRepository;
use App\Contracts\Repositories\IClickRepository;
use App\Entities\BadDomain;
use App\Entities\Click;
use App\Exceptions\BadDomainExistsException;
use App\Exceptions\BadDomainNotFoundException;
use App\Repositories\ClickRepository;
use App\Services\BadDomainService;
use App\Services\ClickService;
use App\ValueObjects\BadDomainId;
use App\ValueObjects\ClickId;
use App\ValueObjects\Domain;
use App\ValueObjects\IpAddress;
use App\ValueObjects\Param;
use App\ValueObjects\Referer;
use App\ValueObjects\UserAgent;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ClickServiceTest extends TestCase
{
    /**
     * @var IClickRepository | MockObject
     */
    private $clickRepository;

    /**
     * @var IBadDomainRepository | MockObject
     */
    private $badDomainRepository;

    /**
     * @var ClickService
     */
    private $service;

    public function setUp()
    {
        $this->clickRepository = $this->getMockBuilder(IClickRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->badDomainRepository = $this->getMockBuilder(IBadDomainRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new ClickService(
            $this->clickRepository,
            $this->badDomainRepository
        );
    }

    public function getTestClick() : Click
    {
        return new Click(
            new ClickId('click-uuid'),
            new UserAgent('User-Agent'),
            new IpAddress('127.0.0.1'),
            new Domain('http://google.com'),
            new Param('param1'),
            new Param('param2')
        );
    }

    public function testAll()
    {
        $expectedResult = [
            $this->getTestClick()
        ];

        $this->clickRepository
            ->method('findAll')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $this->service->all());
    }

    /**
     * Checks saving of new click
     */
    public function testHandlerClick()
    {
        $click = $this->getTestClick();

        $this->assertEquals(0, $click->getErrorsCount());
        $this->assertEquals(false, $click->isBadDomain());

        $this->clickRepository
            ->method('find')
            ->with($click)
            ->willReturn(false);

        $handledClick = $this->service->handlerClick($click);

        $this->assertEquals($click->getId(), $handledClick->getId());
        $this->assertEquals($click->getUserAgent(), $handledClick->getUserAgent());
        $this->assertEquals($click->getIpAddress(), $handledClick->getIpAddress());
        $this->assertEquals($click->getReferer(), $handledClick->getReferer());
        $this->assertEquals($click->getParam1(), $handledClick->getParam1());
        $this->assertEquals($click->getParam2(), $handledClick->getParam2());
        $this->assertEquals($click->getErrorsCount(), $handledClick->getErrorsCount());
        $this->assertEquals(false, $handledClick->isBadDomain());
    }

    /**
     * Checks saving of duplicated click
     * @throws \App\Exceptions\ValueObjects\InvalidBadDomainIdException
     */
    public function testHandlerClickError()
    {
        $click = $this->getTestClick();

        $this->assertEquals(0, $click->getErrorsCount());
        $this->assertEquals(false, $click->isBadDomain());

        $this->clickRepository
            ->method('findOneBy')
            ->with([
                'userAgent' => $click->getUserAgent(),
                'ipAddress' => $click->getIpAddress(),
                'referer'   => $click->getReferer(),
                'param1'    => $click->getParam1(),
            ])
            ->willReturn($click);

        $badDomain = new BadDomain(
            new BadDomainId(),
            $click->getReferer()
        );

        $this->badDomainRepository
            ->method('findByDomain')
            ->with($click->getReferer())
            ->willReturn($badDomain);

        $handledClick = $this->service->handlerClick($click);

        $this->assertEquals($click->getId(), $handledClick->getId());
        $this->assertEquals($click->getUserAgent(), $handledClick->getUserAgent());
        $this->assertEquals($click->getIpAddress(), $handledClick->getIpAddress());
        $this->assertEquals($click->getReferer(), $handledClick->getReferer());
        $this->assertEquals($click->getParam1(), $handledClick->getParam1());
        $this->assertEquals($click->getParam2(), $handledClick->getParam2());
        $this->assertEquals(1, $handledClick->getErrorsCount());
        $this->assertEquals(true, $handledClick->isBadDomain());
    }

    /**
     * Checks saving click from bad domain
     */
    public function testHandlerClickBadDomain()
    {
        $click = $this->getTestClick();

        $this->assertEquals(0, $click->getErrorsCount());

        $this->clickRepository
            ->method('findOneBy')
            ->with([
                'userAgent' => $click->getUserAgent(),
                'ipAddress' => $click->getIpAddress(),
                'referer'   => $click->getReferer(),
                'param1'    => $click->getParam1(),
            ])
            ->willReturn($click);

        $handledClick = $this->service->handlerClick($click);

        $this->assertEquals($click->getId(), $handledClick->getId());
        $this->assertEquals($click->getUserAgent(), $handledClick->getUserAgent());
        $this->assertEquals($click->getIpAddress(), $handledClick->getIpAddress());
        $this->assertEquals($click->getReferer(), $handledClick->getReferer());
        $this->assertEquals($click->getParam1(), $handledClick->getParam1());
        $this->assertEquals($click->getParam2(), $handledClick->getParam2());
        $this->assertEquals(1, $handledClick->getErrorsCount());
    }
}