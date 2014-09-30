<?php

namespace Apihour\UserBundle\Entity;

use Apihour\UserBundle\Entity\User\UserAccount;

/**
 * Interface SwitchableAccount
 * @package Apihour\UserBundle\Entity
 */
interface SwitchableAccount {
    /**
     * @param UserAccount $account
     * @return void
     */
    public function switchUserAccount(UserAccount $account);

    /**
     * @return UserAccount
     */
    public function getCurrentUserAccount();
} 