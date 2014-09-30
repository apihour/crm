<?php

namespace Apihour\FrontendBundle\Repository;

use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Entity\User\UserAccount;
use Apihour\UserBundle\EventListener\Authorization\AccountNotSwitchedException;
use Tutto\CommonBundle\Repository\AbstractEntityRepository as BaseAbstractEntityRepository;

/**
 * Class AbstractEntityRepository
 * @package Apihour\FrontendBundle\Repository
 */
class AbstractEntityRepository extends BaseAbstractEntityRepository {
    /**
     * @return UserAccount
     * @throws AccountNotSwitchedException
     */
    public function getCurrentUserAccount() {
        /** @var User $user */
        $user = $this->getUser();
        if ($user instanceof User) {
            $userAccount = $user->getCurrentUserAccount();
            if ($userAccount === null) {
                throw new AccountNotSwitchedException();
            }

            return $userAccount;
        }
    }
} 