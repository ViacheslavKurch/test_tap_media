<?php

namespace App\Entities;

use App\ValueObjects\Domain;
use Doctrine\ORM\Mapping as ORM;
use App\ValueObjects\BadDomainId;

/**
 * @ORM\Entity
 * @ORM\Table(name="bad_domains")
 */

class BadDomain
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="bad_domain_id")
     */
    private $id;

    /**
     * @var Domain
     *
     * @ORM\Column(type="domain", name="name")
     */
    private $domain;

    /**
     * BadDomain constructor.
     * @param BadDomainId $badDomainId
     * @param Domain $domain
     */
    public function __construct(BadDomainId $badDomainId, Domain $domain)
    {
        $this->id = $badDomainId;
        $this->domain = $domain;
    }

    /**
     * @return BadDomainId
     */
    public function getId() : BadDomainId
    {
        return $this->id;
    }

    /**
     * @return Domain
     */
    public function getDomain() : Domain
    {
        return $this->domain;
    }

    /**
     * @param Domain $domain
     */
    public function setDomain(Domain $domain)
    {
        $this->domain = $domain;
    }
}