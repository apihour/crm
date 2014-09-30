<?php

namespace Tutto\CommonBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;

use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class AbstractContainerAware
 * @package Tutto\CommonBundle\DependencyInjection
 */
class AbstractContainerAware implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->get('request');
    }

    /**
     * @return Router
     */
    public function getRouter() {
        return $this->getContainer()->get('router');
    }

    /**
     * @return UserInterface|null
     */
    public function getUser() {
        /** @var TokenInterface $token */
        $token = $this->container->get('security.context')->getToken();

        if($token !== null) {
            $user = $token->getUser();
            return $user instanceof UserInterface ? $user : null;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isLogged() {
        return $this->getUser() instanceof UserInterface;
    }

    /**
     * @return Session
     */
    public function getSession() {
        return $this->getRequest()->getSession();
    }

    /**
     * @param string $class
     * @return EntityRepository
     */
    public function getRepository($class) {
        $repository = $this->getContainer()->get('doctrine')->getRepository($class);
        if($repository instanceof ContainerAwareInterface) {
            $repository->setContainer($this->getContainer());
        }

        return $repository;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer() {
        if($this->container === null) {
            throw new LogicException("ContainerInterface was never deployed.");
        }

        return $this->container;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @param $key
     * @return object The service
     */
    public function get($key) {
        return $this->getContainer()->get($key);
    }

    /**
     * @param null $name
     * @return EntityManager
     */
    public function getEm($name = null) {
        return $this->get('doctrine')->getManager($name);
    }
}