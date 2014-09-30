<?php

namespace Tutto\SecurityBundle\Security;

use FOS\UserBundle\Security\UserProvider as BaseUserProvider;

use Tutto\SecurityBundle\Security\Exception\UserClassNotSupportedException;
use Tutto\SecurityBundle\Entity\User;

/**
 * Class UserProvider
 * @package Tutto\SecurityBundle\Security
 */
class UserProvider extends BaseUserProvider {
    /**
     * @param string $username
     * @return \FOS\UserBundle\Model\UserInterface|null|\Symfony\Component\Security\Core\User\UserInterface|void
     */
    public function loadUserByUsername($username) {
        $user = parent::loadUserByUsername($username);

        if ($user instanceof User) {
            return $user;
        } else {
            throw new UserClassNotSupportedException("User class: '".get_class($user)."' is not supported.");
        }
    }
} 