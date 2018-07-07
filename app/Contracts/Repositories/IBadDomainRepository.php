<?php

namespace App\Contracts\Repositories;

use App\Entities\BadDomain;
use App\ValueObjects\Domain;
use App\ValueObjects\BadDomainId;
use App\Exceptions\BadDomainNotFoundException;

interface IBadDomainRepository
{
    /**
     * @param BadDomain $badDomain
     * @return mixed
     */
    public function save(BadDomain $badDomain);

    /**
     * @return array
     */
    public function findAll() : array;

    /**
     * @param array $data
     * @return BadDomain|null
     */
    public function findOneBy(array $data) : ?BadDomain;

    /**
     * @param Domain $domain
     * @return BadDomain|null
     */
    public function findByDomain(Domain $domain) : ?BadDomain;

    /**
     * @param BadDomainId $badDomainId
     * @return BadDomain|null
     */
    public function find(BadDomainId $badDomainId) : ?BadDomain;

    /**
     * @param BadDomainId $badDomainId
     * @return BadDomain|null
     * @throws BadDomainNotFoundException
     */
    public function get(BadDomainId $badDomainId) : ?BadDomain;

    /**
     * @param BadDomain $badDomain
     * @return bool
     */
    public function checkUniqueDomain(BadDomain $badDomain) : bool;
}