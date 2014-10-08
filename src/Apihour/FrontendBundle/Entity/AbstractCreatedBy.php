<?php

namespace Apihour\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Apihour\UserBundle\Entity\User\UserAccount;
use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class AbstractCreatedBy
 * @package Apihour\FrontendBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractCreatedBy extends AbstractEntity {
    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User\UserAccount")
     * @ORM\JoinColumn(name="created_by_user_account_id",referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var UserAccount
     */
    protected $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User\UserAccount")
     * @ORM\JoinColumn(name="modified_by_user_account_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var UserAccount
     */
    protected $modifiedBy;

    /**
     * @return UserAccount
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * @param UserAccount $createdBy
     */
    public function setCreatedBy(UserAccount $createdBy) {
        $this->createdBy = $createdBy;
    }

    /**
     * @return UserAccount
     */
    public function getModifiedBy() {
        return $this->modifiedBy;
    }

    /**
     * @param UserAccount $modifiedBy
     */
    public function setModifiedBy(UserAccount $modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }
} 