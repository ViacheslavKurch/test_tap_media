<?php

namespace App\Services;

use App\Entities\Click;
use App\Entities\BadDomain;
use App\ValueObjects\Domain;
use App\Contracts\Repositories\IClickRepository;
use App\Contracts\Repositories\IBadDomainRepository;

class ClickService
{
    /**
     * @var IClickRepository
     */
    private $clickRepository;

    /**
     * @var IBadDomainRepository
     */
    private $badDomainRepository;

    /**
     * ClickService constructor.
     * @param IClickRepository $clickRepository
     * @param IBadDomainRepository $badDomainRepository
     */
    public function __construct(
        IClickRepository $clickRepository,
        IBadDomainRepository $badDomainRepository
    )
    {
        $this->clickRepository = $clickRepository;
        $this->badDomainRepository = $badDomainRepository;
    }

    /**
     * @return array
     */
    public function all() : array
    {
        return $this->clickRepository->findAll();
    }

    /**
     * @param Click $click
     * @return Click
     */
    public function handlerClick(Click $click) : Click
    {
        $existingClick = $this->findClick($click);

        if (null !== $existingClick) {
            $existingClick->incrementErrorsCount();

            if (false === $this->checkClickDomain($existingClick)) {
                $existingClick->setIsBadDomain();
            }

            $click = $existingClick;
        }

        $this->clickRepository->save($click);

        return $click;
    }

    /**
     * @param Click $click
     * @return Click|null
     */
    private function findClick(Click $click) : ?Click
    {
        return $this->clickRepository->findOneBy([
            'userAgent' => $click->getUserAgent(),
            'ipAddress' => $click->getIpAddress(),
            'referer'   => $click->getReferer(),
            'param1'    => $click->getParam1(),
        ]);
    }

    /**
     * Returns true if domain is good, false - if domain is bad
     * @param Click $click
     * @return bool
     */
    private function checkClickDomain(Click $click) : bool
    {
        if ($click->isBadDomain()) {
            return false;
        }

        return null === $this->findBadDomain($click->getReferer());
    }

    /**
     * @param Domain $domain
     * @return Domain|null
     */
    private function findBadDomain(Domain $domain) : ?BadDomain
    {
        return $this->badDomainRepository->findByDomain($domain);
    }
}