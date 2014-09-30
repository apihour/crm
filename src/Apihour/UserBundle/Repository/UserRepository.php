<?php

namespace Apihour\UserBundle\Repository;

use Apihour\UserBundle\Entity\User\UserAccount;
use Tutto\CommonBundle\Repository\AbstractEntityRepository;

/**
 * Class UserRepository
 * @package Tutto\UserBundle\Repository
 */
class UserRepository extends AbstractEntityRepository {
    /**
     * @param $userId
     * @return UserAccount[]
     */
    public function getUserAccounts($userId) {
        $query = $this->createQueryBuilder('u')
                ->select('a')
                ->join('a.user', 'u')
                ->where('u.id = '.(int) $userId);

        return $query->getQuery()->getResult();
    }
} 