<?php

namespace App\Contracts\Repositories;

use App\Entities\Click;
use App\ValueObjects\ClickId;
use App\Exceptions\ClickNotFoundException;

interface IClickRepository
{
    /**
     * @param Click $click
     * @return mixed
     */
    public function save(Click $click);

    /**
     * @return array
     */
    public function findAll() : array;

    /**
     * @param array $data
     * @return Click|null
     */
    public function findOneBy(array $data) : ?Click;

    /**
     * @param ClickId $clickId
     * @return Click|null
     */
    public function find(ClickId $clickId) : ?Click;

    /**
     * @param ClickId $clickId
     * @return Click|null
     * @throws ClickNotFoundException
     */
    public function get(ClickId $clickId) : ?Click;
}