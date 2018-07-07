<?php

namespace App\Services;

use App\Entities\BadDomain;
use App\ValueObjects\BadDomainId;
use App\Exceptions\BadDomainExistsException;
use App\Exceptions\BadDomainNotFoundException;
use App\Contracts\Repositories\IBadDomainRepository;


class BadDomainService
{
    /**
     * @var IBadDomainRepository
     */
    private $badDomainRepository;

    /**
     * BadDomainService constructor.
     * @param IBadDomainRepository $badDomainRepository
     */
    public function __construct(IBadDomainRepository $badDomainRepository)
    {
        $this->badDomainRepository = $badDomainRepository;
    }

    public function all() : array
    {
        return $this->badDomainRepository->findAll();
    }

    /**
     * @param BadDomainId $badDomainId
     * @return BadDomain
     * @throws BadDomainNotFoundException
     */
    public function getBadDomain(BadDomainId $badDomainId) : BadDomain
    {
        return $this->badDomainRepository->get($badDomainId);
    }

    /**
     * @param BadDomain $badDomain
     * @throws BadDomainExistsException
     */
    public function save(BadDomain $badDomain)
    {
        $this->checkUniqueBadDomain($badDomain);
        $this->badDomainRepository->save($badDomain);
    }

    /**
     * @param BadDomain $badDomain
     * @throws BadDomainExistsException
     */
    private function checkUniqueBadDomain(BadDomain $badDomain)
    {
        if (false === $this->badDomainRepository->checkUniqueDomain($badDomain)) {
            throw new BadDomainExistsException();
        }
    }
}