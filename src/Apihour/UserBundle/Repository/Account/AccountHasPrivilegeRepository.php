<?php

namespace Apihour\UserBundle\Repository\Account;

use Apihour\UserBundle\Entity\User\UserAccount;
use Doctrine\ORM\NoResultException;

use Tutto\CommonBundle\Repository\AbstractEntityRepository;
use Tutto\CommonBundle\Tools\Status;

use LogicException;

/**
 * Class AccountHasPrivilegeRepository
 * @package Apihour\UserBundle\Repository\Account
 */
class AccountHasPrivilegeRepository extends AbstractEntityRepository {
    const MAX_USERS_PER_ACCOUNT        = 'max_users_per_account';
    const CAN_CREATE_PRODUCTS_PACKAGES = 'can_create_products_packages';

    /**
     * @param UserAccount $userAccount
     * @param $control
     * @return mixed
     */
    public function getControlValue(UserAccount $userAccount, $control) {
        $query = $this->createQueryBuilder('accounts_has_privileges')
            ->select('accounts_has_privileges.value')
            ->innerJoin('accounts_has_privileges.privilege', 'accounts_privileges')
            ->innerJoin("accounts_has_privileges.account", 'account')
            ->andWhere("accounts_privileges.name = '{$control}' AND accounts_privileges.status = ".Status::ENABLED)
            ->andWhere("accounts_has_privileges.status = ".Status::ENABLED." AND accounts_has_privileges.isDeleted = FALSE")
            ->andWhere("account.id = ".$userAccount->getId());

        try {
            return $query->getQuery()->getSingleScalarResult();
        } catch(NoResultException $ex) {
            return false;
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return array|object|void
     * @throws LogicException
     */
    public function __call($name, $arguments = []) {
        if ($this->hasMethod($name)) {
            return $this->{$name}($arguments);
        } else {
            throw new LogicException("Method: '{$name}' not found.");
        }
    }

    /**
     * @param string|callable $method
     * @return bool
     */
    public function hasMethod($method) {
        if (is_string($method)) {
            return method_exists($this, $method);
        } elseif (is_callable($method)) {
            return true;
        } else {
            return false;
        }
    }
} 