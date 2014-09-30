<?php

namespace Tutto\CommonBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Tutto\CommonBundle\DependencyInjection\ContainerAwareInterface;

use LogicException;
use Tutto\SecurityBundle\Entity\User;

/**
 * Class AbstractFormType
 * @package Tutto\CommonBundle\Form
 */
abstract class AbstractFormType extends AbstractType implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container = null) {
        $this->container = $container;
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
     * @return ContainerInterface
     */
    public function getContainer() {
        if($this->container === null) {
            throw new LogicException("ContainerInterface was never deployed");
        }

        return $this->container;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->getContainer()->get('request');
    }

    /**
     * @return User|null
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
     * @return Router
     */
    public function getRouter() {
        return $this->getContainer()->get('router');
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
        if ($repository instanceof ContainerAwareInterface) {
            $repository->setContainer($this->container);
        }

        return $repository;
    }

    /**
     * @param null $name
     * @return EntityManager|object
     */
    public function getEm($name = null) {
        return $this->getContainer()->get('doctrine')->getManager($name);
    }

    /**
     * @return FormFactory
     */
    public function getFormFactory() {
        return $this->getContainer()->get('form.factory');
    }
}