<?php

namespace App\Services;

use App\Entities\Click;
use App\ValueObjects\ClickId;
use App\Exceptions\ClickNotFoundException;
use App\Exceptions\MethodNotAllowedException;
use App\Contracts\Repositories\IClickRepository;

class ResponseService
{
    /**
     * @var IClickRepository
     */
    private $clickRepository;

    /**
     * ResponseService constructor.
     * @param IClickRepository $clickRepository
     */
    public function __construct(IClickRepository $clickRepository)
    {
        $this->clickRepository = $clickRepository;
    }

    /**
     * @param ClickId $clickId
     * @return Click
     * @throws MethodNotAllowedException
     * @throws ClickNotFoundException
     */
    public function getSuccessData(ClickId $clickId) : Click
    {
        $click = $this->getClick($clickId);

        if ($click->getErrorsCount() > 0) {
            throw new MethodNotAllowedException();
        }

        return $click;
    }

    /**
     * @param ClickId $clickId
     * @return Click
     * @throws MethodNotAllowedException
     * @throws ClickNotFoundException
     */
    public function getErrorData(ClickId $clickId) : Click
    {
        $click = $this->getClick($clickId);

        if (0 === $click->getErrorsCount()) {
            throw new MethodNotAllowedException();
        }

        return $click;
    }

    /**
     * @param ClickId $clickId
     * @return Click
     * @throws ClickNotFoundException
     */
    private function getClick(ClickId $clickId) : Click
    {
        return $this->clickRepository->get($clickId);
    }
}