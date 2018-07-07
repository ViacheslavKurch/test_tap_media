<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\IBadDomainRepository;
use App\Entities\BadDomain;
use App\Exceptions\BadDomainExistsException;
use App\Exceptions\BadDomainNotFoundException;
use App\Services\BadDomainService;
use App\ValueObjects\BadDomainId;
use App\ValueObjects\Domain;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class BadDomainServiceTest extends TestCase
{
    /**
     * @var IBadDomainRepository | MockObject
     */
    private $repository;

    /**
     * @var BadDomainService
     */
    private $service;

    public function setUp()
    {
        $this->repository = $this->getMockBuilder(IBadDomainRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new BadDomainService($this->repository);
    }

    public function testAll()
    {
        $expectedData = [
            new BadDomain(new BadDomainId('uuid-1'), new Domain('http://google.com')),
            new BadDomain(new BadDomainId('uuid-2'), new Domain('http://facebook.com')),
        ];

        $this->repository->method('findAll')
            ->willReturn($expectedData);

        $this->assertEquals($expectedData, $this->service->all());
    }

    public function testFindSuccess()
    {
        $domainId = new BadDomainId('uuid-1');
        $domain = new Domain('http://google.com');

        $expectedResult = new BadDomain($domainId, $domain);

        $this->repository->method('get')
            ->with($domainId)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $this->service->getBadDomain($domainId));
    }

    public function testBadDomainNotFound()
    {
        $domainId = new BadDomainId('uuid-1');

        $this->repository->method('get')
            ->with($domainId)
            ->willThrowException(new BadDomainNotFoundException());

        $this->expectException(BadDomainNotFoundException::class);

        $this->service->getBadDomain($domainId);
    }

    public function testSaveSuccess()
    {
        $domainId = new BadDomainId('uuid-1');
        $domain = new Domain('http://google.com');

        $domain = new BadDomain($domainId, $domain);

        $this->repository
            ->method('checkUniqueDomain')
            ->with($domain)
            ->willReturn(true);

        $this->service->save($domain);

        $this->assertEquals($domainId, $domain->getId());
        $this->assertEquals($domain->getDomain(), $domain->getDomain()->getValue());
    }

    public function testSaveFailed()
    {
        $domainId = new BadDomainId('uuid-1');
        $domain = new Domain('http://google.com');

        $domain = new BadDomain($domainId, $domain);

        $this->repository->method('checkUniqueDomain')
            ->with($domain)
            ->willReturn(false);

        $this->expectException(BadDomainExistsException::class);

        $this->service->save($domain);
    }
}