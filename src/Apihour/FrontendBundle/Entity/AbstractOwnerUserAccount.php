<?php

namespace Apihour\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Apihour\UserBundle\Entity\User\UserAccount;

/**
 * Class AbstractOwnerUserAccount
 * @package Apihour\FrontendBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractOwnerUserAccount extends AbstractCreatedBy {
    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User\UserAccount")
     * @ORM\JoinColumn(name="owner_user_account_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var UserAccount
     */
    protected $ownerUserAccount;

    /**
     * @return UserAccount
     */
    public function getOwnerUserAccount() {
        return $this->ownerUserAccount;
    }

    /**
     * @param UserAccount $ownerUserAccount
     */
    public function setOwnerUserAccount(UserAccount $ownerUserAccount) {
        $this->ownerUserAccount = $ownerUserAccount;
    }
} 