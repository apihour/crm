<?php

namespace Tutto\SecurityBundle\Listeners;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Tutto\SecurityBundle\Security\Exception\UserSuspendedException;
use Tutto\SecurityBundle\Util\SuspendedInterface;

/**
 * Class UserSuspendedCheckListener
 * @package Tutto\SecurityBundle\Listeners
 */
class UserSuspendedCheckListener extends AbstractContainerAware {
    /**
     * @param FilterControllerEvent $event
     */
    public function handle(FilterControllerEvent $event) {
        if ($this->getUser() instanceof SuspendedInterface) {
            if ('tutto_auth_activate' != $event->getRequest()->get('_route')) {
                if ($this->getUser()->isSuspend() && $event->isMasterRequest()) {
                    throw new UserSuspendedException();
                }
            }
        }
    }
} 