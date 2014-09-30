<?php

namespace Apihour\UserBundle\EventListener;

use Apihour\UserBundle\Configuration\AccountPrivilege;
use Apihour\UserBundle\Entity\Account\AccountHasPrivilege;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\EventListener\AccountPrivilege\AccountHasNoControlException;
use Apihour\UserBundle\EventListener\Authorization\AccountNotSwitchedException;
use Apihour\UserBundle\Repository\Account\AccountHasPrivilegeRepository;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\Common\Annotations\AnnotationReader;
use Apihour\UserBundle\Entity\User\UserAccount;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

use LogicException;
use ReflectionObject;
use ReflectionMethod;

/**
 * Class AccountPrivilegeListener
 * @package Tutto\SecurityBundle\Listeners
 */
class AccountPrivilegeListener extends AbstractContainerAware {
    /**
     * @param FilterControllerEvent $event
     * @throws AccountHasNoControlException
     * @throws AccountNotSwitchedException
     */
    public function handle(FilterControllerEvent $event) {
        if (!$event->isMasterRequest()) {
            return ;
        }

        if (!isset($event->getController()[0]) || !isset($event->getController()[1])) {
            throw new LogicException($this->trans('exceptions:notController'));
        }

        list($controller, $action) = $event->getController();
        $reader           = new AnnotationReader();
        $isAllowed        = true;
        $controls         = [];

        /** Sprawdzamy kontrolki konta użytkownika dla kontrolera. */
        foreach ($reader->getClassAnnotations(new ReflectionObject($controller)) as $annotation) {
            if ($annotation instanceof AccountPrivilege && !$this->checkControl($annotation)) {
                $isAllowed  = false;
                $controls[] = $annotation->getControl();
            }
        }

        /** Sprawdzamy kontrolki konta użytkownika dla akcji kontrolera. */
        foreach ($reader->getMethodAnnotations(new ReflectionMethod($controller, $action)) as $annotation) {
            if ($annotation instanceof AccountPrivilege && !$this->checkControl($annotation)) {
                $isAllowed  = false;
                $controls[] = $annotation->getControl();
            }
        }

        if (!$isAllowed) {
            throw new AccountHasNoControlException(
                $this->trans(
                    "exceptions:accountHasNoControl",
                    ['%controls%' => implode(', ', $controls)]
                )
            );
        }
    }

    /**
     * @param AccountPrivilege $annotation
     * @return bool
     * @throws AccountNotSwitchedException
     */
    protected function checkControl(AccountPrivilege $annotation) {
        /** @var User $user */
        $user = $this->getUser();

        /** @var AccountHasPrivilegeRepository $accountPrivilege */
        $accountPrivilege = $this->getRepository(AccountHasPrivilege::class);

        if (($account = $user->getCurrentUserAccount()) instanceof UserAccount) {
            return
                ($accountPrivilege->hasMethod($annotation->getControl()) && $accountPrivilege->{$annotation->getControl()}())
                || (boolean) $accountPrivilege->getControlValue($account, $annotation->getControl());
        } else {
            throw new AccountNotSwitchedException();
        }
    }

    /**
     * @param $message
     * @param array $parameters
     * @return string
     */
    protected function trans($message, array $parameters = []) {
        return $this->get('translator')->trans($message, $parameters);
    }
} 