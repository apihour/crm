<?php

namespace Tutto\CommonBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator;
use Tutto\CommonBundle\DependencyInjection\ContainerAwareInterface;
use Tutto\CommonBundle\PropertyAccess\PropertyAccessor;
use Tutto\SecurityBundle\Entity\User;

/**
 * Class AbstractEntityRepository
 * @package Tutto\CommonBundle\Repository
 */
class AbstractEntityRepository extends EntityRepository implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->getContainer()->get('request');
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
        return $this->container;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @param null $name
     * @return EntityManager
     */
    public function getEm($name = null) {
        return $this->getContainer()->get('doctrine')->getManager($name);
    }

    /**
     * @param $id
     * @param $key
     * @param $value
     * @return int|string
     */
    public function updateByKeyValue($id, $key, $value) {
        $object = $this->find($id);

        /** @var Validator $validator */
        $validator = $this->getContainer()->get('validator');

        $accessor = new PropertyAccessor();
        $accessor->setValue($object, $key, $value);
        $errors = $validator->validate($object);

        if (count($errors) <= 0) {
            $this->getEm()->flush();
            return count($errors);
        }
        else {
            return (string) $errors;
        }
    }
}