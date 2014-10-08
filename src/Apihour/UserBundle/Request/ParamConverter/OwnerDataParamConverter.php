<?php

namespace Apihour\UserBundle\Request\ParamConverter;

use Apihour\UserBundle\Entity\Account;
use Apihour\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Apihour\FrontendBundle\Entity\AbstractOwnerUserAccount;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class OwnerDataParamConverter
 * @package Apihour\UserBundle\Request\ParamConverter
 */
class OwnerDataParamConverter extends DoctrineParamConverter {
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        parent::__construct($container->get('doctrine'));
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration) {
        $isValid = parent::apply($request, $configuration);
        if ($isValid === true) {
            /** @var User $user */
            $user   = $this->container->get('security.context')->getToken()->getUser();
            $entity = $request->attributes->get($configuration->getName());

            if ($this->check($entity, $user)) {
                return true;
            } else {
                throw new NotFoundHttpException('Not found');
            }
        } else {
            return false;
        }
    }

    /**
     * @param $entity
     * @param User $user
     * @return bool
     */
    protected function check($entity, User $user) {
        if ($user === null || $entity === null) {
            return true;
        } else {
            if ($user->getCurrentUserAccount() !== null && $entity !== null) {
                if ($entity instanceof Account) {
                    return $user->getCurrentUserAccount()->getId() === $entity->getId();
                } elseif($entity instanceof AbstractOwnerUserAccount) {
                    return $user->getCurrentUserAccount()->getId() === $entity->getOwnerUserAccount()->getId();
                }
            }
        }

        return false;
    }

    /**
     * @param ParamConverter $configuration
     * @return bool|void
     */
    public function supports(ParamConverter $configuration) {
        $class = $configuration->getClass();
        if ($class === null) {
            return false;
        }
        $object = new $class;

        return $object instanceof AbstractOwnerUserAccount || $object instanceof Account ;
    }
}