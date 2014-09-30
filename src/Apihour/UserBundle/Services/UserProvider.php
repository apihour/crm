<?php

namespace Apihour\UserBundle\Services;

use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use FOS\UserBundle\Security\UserProvider as BaseUserProvider;

use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Exceptions\User\UserDisabledException;

/**
 * Class UserProvider
 * @package Apihour\UserBundle\Services
 */
class UserProvider extends BaseUserProvider {
    /**
     * @param string $username
     * @return User|null
     */
    public function loadUserByUsername($username) {
        $user = parent::loadUserByUsername($username);

        if ($user instanceof User) {
            return $this->checkUser($user);
        }
    }

    /**
     * @param SecurityUserInterface $user
     * @return User|null
     */
    public function refreshUser(SecurityUserInterface $user) {
        $reloadedUser = parent::refreshUser($user);

        if ($reloadedUser instanceof User) {
            return $this->checkUser($reloadedUser);
        }
    }

    /**
     * @param User $user
     * @return User
     */
    protected function checkUser(User $user) {
        if (!$user->isEnabled()) {
            throw new UserDisabledException("Your profile is disabled.");
        } else {
            return $user;
        }
    }
} 