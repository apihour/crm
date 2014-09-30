<?php

namespace Apihour\UserBundle\Services;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

use Apihour\UserBundle\Entity\User;
use Tutto\SecurityBundle\Security\UserManager as BaseUserManager;

/**
 * Class UserManager
 * @package Apihour\UserBundle\Services
 */
class UserManager extends BaseUserManager {
    /**
     * @param string $username
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findUserByUsername($username) {
        $query = $this->repository->createQueryBuilder('u')
                ->select('u')
                ->andWhere("u.usernameCanonical = '{$username}'");

        try {
            /** @var User $user */
            $user = $query->getQuery()->getSingleResult();

            /** Ustawiamy tak żeby user na początku logowania niemiał żadnego wybranego konta. */
            foreach ($user->getUserAccounts() as $account) {
                if ($account->isSelected()) {
                    $account->diselect();
                }
            }

            $this->objectManager->persist($user);
            $this->objectManager->flush();

            return $user;
        } catch (NoResultException $ex) {
            return null;
        }
    }
} 