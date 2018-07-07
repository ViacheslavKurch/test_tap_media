<?php

namespace App\Repositories;

use App\Entities\Click;
use App\Exceptions\ClickNotFoundException;
use App\ValueObjects\ClickId;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use App\Contracts\Repositories\IClickRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class ClickRepository implements IClickRepository
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
     * @param Click $click
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Click $click)
    {
        $this->entityManager->merge($click);
        $this->entityManager->flush();
    }

    /**
     * @return array
     */
    public function findAll() : array
    {
        return $this->getEntityRepository()->findAll();
    }

    /**
     * @param array $data
     * @return Click|null
     */
    public function findOneBy(array $data) : ?Click
    {
        return $this->getEntityRepository()->findOneBy($data);
    }

    /**
     * @param ClickId $clickId
     * @return Click|null
     */
    public function find(ClickId $clickId) : ?Click
    {
        return $this->getEntityRepository()->find($clickId);
    }

    /**
     * @return string
     */
    private function getEntityName() : string
    {
        return Click::class;
    }

    /**
     * @return ObjectRepository|EntityRepository
     */
    private function getEntityRepository()
    {
        return $this->entityManager->getRepository($this->getEntityName());
    }

    /**
     * @param ClickId $clickId
     * @return Click|null
     * @throws ClickNotFoundException
     */
    public function get(ClickId $clickId): ?Click
    {
        $click = $this->find($clickId);

        if (null === $click) {
            throw new ClickNotFoundException();
        }

        return $click;
    }
}