<?php

namespace Apihour\UserBundle\EventListener;

use Apihour\UserBundle\Configuration\UserAccountControl;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use ReflectionMethod;
use ReflectionClass;

/**
 * Listener do sprawdzania kontrolek na kontach użytkowników.
 *
 * Class UserAccountControlListener
 * @package Apihour\UserBundle\EventListener
 */
class UserAccountControlListener extends AbstractContainerAware {
    /**
     * @param FilterControllerEvent $event
     */
    public function handle(FilterControllerEvent $event) {
        if (!$event->isMasterRequest()) {
            return ;
        }

        $reader = new AnnotationReader();
        list($controller, $action) = $event->getController();

        /** @var UserAccountControl $annotation */
        if (($annotation = $reader->getMethodAnnotation(new ReflectionMethod($controller, $action), UserAccountControl::class))) {
            $this->callControls($annotation);
            return ;
        }

        if (($annotation = $reader->getClassAnnotation(new ReflectionClass($controller), UserAccountControl::class))) {
            $this->callControls($annotation);
            return ;
        }
    }

    /**
     * @param UserAccountControl $userControl
     */
    public function callControls(UserAccountControl $userControl) {
        foreach ($userControl->getControls() as $control) {
            if (is_callable([$this, $control])) {
                $this->{$control}();
            } else {
                /** todo dodać sprawdzanie w bazie z tabelą users_has_accounts_has_controls */
            }
        }
    }
} 