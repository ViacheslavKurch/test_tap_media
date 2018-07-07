<?php

namespace App\Entities;

use App\ValueObjects\Param;
use App\ValueObjects\Domain;
use App\ValueObjects\ClickId;
use App\ValueObjects\UserAgent;
use App\ValueObjects\IpAddress;
use Doctrine\ORM\Mapping as ORM;
use App\Exceptions\ValueObjects\InvalidParamException;
use App\Exceptions\ValueObjects\InvalidDomainException;
use App\Exceptions\ValueObjects\InvalidClickIdException;
use App\Exceptions\ValueObjects\InvalidIpAddressException;
use App\Exceptions\ValueObjects\InvalidUserAgentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="clicks")
 */
class Click
{
    const STEP_ERROR = 1;

    /**
     * @var ClickId
     *
     * @ORM\Id
     * @ORM\Column(type="click_id")
     */
    private $id;

    /**
     * @var UserAgent
     *
     * @ORM\Column(type="user_agent", name="ua")
     */
    private $userAgent;

    /**
     * @var IpAddress
     *
     * * @ORM\Column(type="ip_address", name="ip")
     */
    private $ipAddress;

    /**
     * @var Domain
     *
     * @ORM\Column(type="domain", name="ref")
     */
    private $referer;

    /**
     * @var string
     *
     * @ORM\Column(type="param", name="param1")
     */
    private $param1;

    /**
     * @var string
     *
     * @ORM\Column(type="param", name="param2")
     */
    private $param2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="error")
     */
    private $errorsCount;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="bad_domain")
     */
    private $isBadDomain;

    public function __construct(
        ClickId $clickId,
        UserAgent $userAgent,
        IpAddress $ipAddress,
        Domain $referer,
        Param $param1,
        Param $param2,
        int $errorsCount = 0,
        bool $isBadDomain = false
    )
    {
        $this->id = $clickId;
        $this->userAgent = $userAgent;
        $this->ipAddress = $ipAddress;
        $this->referer = $referer;
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->errorsCount = $errorsCount;
        $this->isBadDomain = $isBadDomain;
    }

    /**
     * @return ClickId
     */
    public function getId() : ClickId
    {
        return $this->id;
    }

    /**
     * @return UserAgent
     */
    public function getUserAgent() : UserAgent
    {
        return $this->userAgent;
    }

    /**
     * @return IpAddress
     */
    public function getIpAddress() : IpAddress
    {
        return $this->ipAddress;
    }

    /**
     * @return Domain
     */
    public function getReferer() : Domain
    {
        return $this->referer;
    }

    /**
     * @return Param
     */
    public function getParam1() : Param
    {
        return $this->param1;
    }

    /**
     * @return Param
     */
    public function getParam2() : Param
    {
        return $this->param2;
    }

    /**
     * @return int
     */
    public function getErrorsCount() : int
    {
        return $this->errorsCount;
    }

    /**
     * @return bool
     */
    public function isBadDomain() : bool
    {
        return $this->isBadDomain;
    }

    /**
     * @param bool $isBadDomain
     */
    public function setIsBadDomain(bool $isBadDomain = true)
    {
        $this->isBadDomain = $isBadDomain;
    }

    /**
     * @param int $step
     */
    public function incrementErrorsCount($step = self::STEP_ERROR)
    {
        $this->errorsCount += $step;
    }

    /**
     * @param $data
     * @return Click
     * @throws InvalidClickIdException
     * @throws InvalidDomainException
     * @throws InvalidIpAddressException
     * @throws InvalidParamException
     * @throws InvalidUserAgentException
     */
    public static function createFromArray($data)
    {
        return new static(
            new ClickId(),
            new UserAgent($data['user_agent']),
            new IpAddress($data['ip']),
            new Domain($data['referer']),
            new Param($data['param1']),
            new Param($data['param2'])
        );
    }
}