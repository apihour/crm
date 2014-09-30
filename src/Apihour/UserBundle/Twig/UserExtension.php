<?php

namespace Apihour\UserBundle\Twig;

use Apihour\FileBundle\Entity\File;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Entity\User\UserAccount;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class UserExtension
 * @package Apihour\UserBundle\Twig
 */
class UserExtension extends Twig_Extension implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            new Twig_SimpleFunction('user', [$this, 'user'])
        ];
    }

    /**
     * @return $this
     */
    public function user() {
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser() {
        /** @var TokenInterface $token */
        $token = $this->container->get('security.context')->getToken();
        $user  = $token->getUser();

        return $user instanceof User ? $user : null;
    }

    /**
     * @return UserAccount|null
     */
    public function getCurrentUserAccount() {
        if ($this->getUser() !== null) {
            return $this->getUser()->getCurrentUserAccount();
        } else {
            return null;
        }
    }

    /**
     * @return null|string
     */
    public function getFirstname() {
        if (($account = $this->getCurrentUserAccount()) !== null) {
            return $account->getPerson()->getFirstname();
        } else {
            return null;
        }
    }

    /**
     * @return null|string
     */
    public function getLastname() {
        if (($account = $this->getCurrentUserAccount()) !== null) {
            return $account->getPerson()->getLastname();
        } else {
            return null;
        }
    }

    /**
     * @return File|null
     */
    public function getAvatar() {
        if (($account = $this->getCurrentUserAccount()) !== null) {
            return $account->getPerson()->getAvatar();
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getName() {
        return 'apihour_user_userextension';
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}