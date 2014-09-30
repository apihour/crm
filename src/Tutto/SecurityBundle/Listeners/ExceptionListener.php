<?php

namespace Tutto\SecurityBundle\Listeners;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Tutto\SecurityBundle\Listeners\Authorization\UserNotLoggedException;
use Tutto\SecurityBundle\Security\Exception\UserSuspendedException;

/**
 * Class ExceptionListener
 * @package Tutto\SecurityBundle\Listeners
 */
class ExceptionListener extends AbstractContainerAware {
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating) {
        $this->templating = $templating;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event) {
        $env = $this->getContainer()->getParameter('kernel.environment');
        if($env === 'prod') {
            if ($event->getRequest()->isXmlHttpRequest()) {
                $event->setResponse(new JsonResponse(['exceptions']));
            } else {
                $event->setResponse(
                    $this->templating->renderResponse(
                        '::exception.prod.html.twig',
                        ['exception' => $event->getException()]
                    )
                );
            }

            $event->stopPropagation();
        }

        if($event->isMasterRequest()) {
            if($this->getUser() === null && $event->getException() instanceof UserNotLoggedException) {
                $event->setResponse(new RedirectResponse($this->getRouter()->generate('_login')));
                return ;
            } elseif ($this->getUser() !== null && $event->getException() instanceof UserSuspendedException) {
                $event->setResponse(new RedirectResponse($this->getRouter()->generate('tutto_auth_activate')));
                return ;
            }
        }
    }
} 