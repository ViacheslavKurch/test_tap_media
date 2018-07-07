<?php

namespace App\Repositories;

use App\Entities\BadDomain;
use App\ValueObjects\Domain;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityManager;
use App\ValueObjects\BadDomainId;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\NonUniqueResultException;
use App\Exceptions\BadDomainNotFoundException;
use Doctrine\Common\Persistence\ObjectRepository;
use App\Contracts\Repositories\IBadDomainRepository;


class BadDomainRepository implements IBadDomainRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ClickRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param BadDomain $badDomain
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(BadDomain $badDomain)
    {
        $this->entityManager->merge($badDomain);
        $this->entityManager->flush();
    }

    /**
     * @return array
     */
    public function findAll() : array
    {
        return $this->getEntityRepository()->findAll();
    }

    public function findOneBy(array $data): ?BadDomain
    {
        return $this->getEntityRepository()->findOneBy($data);
    }

    /**
     * @param Domain $domain
     * @return BadDomain|null
     */
    public function findByDomain(Domain $domain) : ?BadDomain
    {
        return $this->getEntityRepository()->findOneBy([
            'domain' => $domain
        ]);
    }

    /**
     * @param BadDomainId $badDomainId
     * @return BadDomain|null
     */
    public function find(BadDomainId $badDomainId) : ?BadDomain
    {
        return $this->getEntityRepository()->find($badDomainId);
    }

    /**
     * @param BadDomain $badDomain
     * @return bool
     * @throws NonUniqueResultException
     */
    public function checkUniqueDomain(BadDomain $badDomain): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $query = $queryBuilder->select(array('b'))
            ->from($this->getEntityName(), 'b')
            ->where(
                $queryBuilder->expr()->eq('b.domain', ':domain'),
                $queryBuilder->expr()->neq('b.id', ':id')
            )
            ->setParameters([
                ':domain' => $badDomain->getDomain(),
                ':id'     => $badDomain->getId()
            ])
            ->getQuery();

        return null === $query->getOneOrNullResult();
    }

    /**
     * @param BadDomainId $badDomainId
     * @return BadDomain|null
     * @throws BadDomainNotFoundException
     */
    public function get(BadDomainId $badDomainId): ?BadDomain
    {
        $badDomain = $this->find($badDomainId);

        if (null === $badDomain) {
            throw new BadDomainNotFoundException();
        }

        return $badDomain;
    }

    /**
     * @return string
     */
    private function getEntityName() : string
    {
        return BadDomain::class;
    }

    /**
     * @return ObjectRepository|EntityRepository
     */
    private function getEntityRepository()
    {
        return $this->entityManager->getRepository($this->getEntityName());
    }
}