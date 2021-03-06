<?php

namespace Tutto\CommonBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface as BaseContainerAwareInterface;
use Tutto\SecurityBundle\Entity\User;

/**
 * Interface ContainerAwareInterface
 * @package Tutto\CommonBundle\DependencyInjection
 */
interface ContainerAwareInterface extends BaseContainerAwareInterface {
    /**
     * @return Request
     */
    public function getRequest();

    /**
     * @return Router
     */
    public function getRouter();

    /**
     * @return Session
     */
    public function getSession();

    /**
     * @return User|null
     */
    public function getUser();

    /**
     * @param string $class
     * @return EntityRepository
     */
    public function getRepository($class);

    /**
     * @param null $name
     * @return EntityManager
     */
    public function getEm($name = null);

    /**
     * @return ContainerInterface
     */
    public function getContainer();
} 