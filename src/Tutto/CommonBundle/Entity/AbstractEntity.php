<?php

namespace Tutto\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use DateTime;
use Tutto\CommonBundle\Util\Status;

/**
 * Class AbstractEntity
 * @package Tutto\FrontendBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractEntity {
    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime
     */
    protected $modifiedAt;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $status = Status::ENABLED;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $isDeleted = false;

    public function __construct() {
        $this->setCreatedAt(new DateTime());
        $this->setModifiedAt(new DateTime());
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt = null) {
        $this->createdAt = $createdAt;
    }

    /**
     * @return boolean
     */
    public function isDeleted() {
        return $this->isDeleted;
    }

    /**
     * @param boolean $isDeleted
     */
    public function setIsDeleted($isDeleted) {
        $this->isDeleted = (boolean) $isDeleted;
    }

    /**
     * @return DateTime
     */
    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    /**
     * @param DateTime $modifiedAt
     */
    public function setModifiedAt(DateTime $modifiedAt = null) {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status = Status::ENABLED) {
        $this->status = (int) $status;
    }

    /**
     * @return bool
     */
    public function isEnabled() {
        return $this->getStatus() === Status::ENABLED;
    }
} 