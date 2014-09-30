<?php

namespace Apihour\UserBundle\EventListener;

use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\Common\Annotations\AnnotationReader;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Apihour\UserBundle\Entity\Role;
use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\SecurityBundle\Listeners\Authorization\PermissionDeniedException;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Tutto\SecurityBundle\Configuration\Authorization;
use Tutto\SecurityBundle\Listeners\Authorization\UserNotLoggedException;
use Tutto\SecurityBundle\Repository\RoleRepository;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Entity\User\UserAccount;
use Apihour\UserBundle\EventListener\Authorization\AccountNotSwitchedException;
use ReflectionMethod;
use LogicException;
use ReflectionObject;

/**
 * Class AuthorizationListener
 * @package Apihour\UserBundle\EventListener
 */
class AuthorizationListener extends AbstractContainerAware implements EventSubscriberInterface {
    /**
     * @var array
     */
    protected $excludedRoutes = [];

    /**
     * @var string
     */
    protected $redirectRouteName;

    /**
     * @return array|void
     */
    public static function getSubscribedEvents() {
        return [
            'kernel.controller' => [
                ['handleRequest', 10]
            ],
            'kernel.exception' => [
                ['handleException', 11]
            ]
        ];
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function handleException(GetResponseForExceptionEvent $event) {
        if ($event->getException() instanceof AccountNotSwitchedException) {
            if ($event->isMasterRequest()) {
                $event->setResponse(new RedirectResponse($this->getRouter()->generate($this->getRedirectRouteName())));
                $event->stopPropagation();
            }
        }
    }

    /**
     * @param FilterControllerEvent $event
     * @throws AccountNotSwitchedException
     * @throws PermissionDeniedException
     * @throws UserNotLoggedException
     */
    public function handleRequest(FilterControllerEvent $event) {
        if (!$event->isMasterRequest()) {
            return ;
        }

        $request = $this->container->get('request');
        $user    = $this->getUser();

        /** Sprawdzanie czy użytkownik ma wybrane konto. */
        if ($user instanceof User) {
            /** Jeśli użytkownik nie ma ustawionego konta to rzucamy exception. */
             if ($user->getCurrentUserAccount() === null && !in_array($request->get('_route'), $this->getExcludedRoutes())) {
                throw new AccountNotSwitchedException();
             } elseif($user->getCurrentUserAccount() === null && in_array($request->get('_route'), $this->getExcludedRoutes())) {
                 return true;
             }
        }

        if (!isset($event->getController()[0]) || !isset($event->getController()[1])) {
            throw new LogicException("This is not controller");
        }

        $controller = $event->getController()[0];
        $action     = $event->getController()[1];
        $reader     = new AnnotationReader();

        if (!$controller instanceof AbstractController) {
            return ;
        }

        $annotation = $reader->getMethodAnnotation(new ReflectionMethod($controller, $action), Authorization::class);
        if ($annotation) {
            if ($this->checkPermission($annotation)) {
                return ;
            } else {
                throw new PermissionDeniedException($this->trans('exceptions:permissionDenied'));
            }
        }

        /** Jeśli akcja nie posiada adnotacji to sprawdzamy czy ma dostęp do kontrolera. */
        $annotation = $reader->getClassAnnotation(new ReflectionObject($controller), Authorization::class);
        if ($annotation) {
            if ($this->checkPermission($annotation)) {
                return ;
            } else {
                throw new PermissionDeniedException($this->trans('exceptions:permissionDenied'));
            }
        }

        /** Jeśli kontroler i akcja nie posiadają adnotacji - rzucamy wyjątek. */
        if (!in_array($this->get('kernel')->getEnvironment(), ['dev', 'test']) || !$controller instanceof ProfilerController) {
            throw new LogicException(
                $this->trans(
                    'exceptions:notImplementsAuthorizationAnnotation',
                    [
                        '%controller%' => get_class($controller),
                        '%action%'     => $action
                    ]
                )
            );
        }
    }

    /**
     * @return string
     */
    public function getRedirectRouteName() {
        return $this->redirectRouteName;
    }

    /**
     * @param string $redirectRouteName
     */
    public function setRedirectRouteName($redirectRouteName) {
        $this->redirectRouteName = (string) $redirectRouteName;
    }

    /**
     * @param array $routes
     */
    public function setExcludedRoutes(array $routes) {
        $this->excludedRoutes = $routes;
    }

    /**
     * @param $route
     */
    public function addExcludedRoute($route) {
        $this->excludedRoutes[] = $route;
    }

    /**
     * @return array
     */
    public function getExcludedRoutes() {
        return $this->excludedRoutes;
    }

    /**
     * @param Authorization $authorization
     * @return bool
     * @throws AccountNotSwitchedException
     * @throws UserNotLoggedException
     */
    protected function checkPermission(Authorization $authorization) {
        if ($authorization->isOmit()) {
            return true;
        }

        /** @var User $user */
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new UserNotLoggedException($this->trans('exceptions:userNotLogged'));
        }

        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(Role::class);
        $account        = $user->getCurrentUserAccount();

        if ($account === null) {
            return false;
        } else {
            $accountRole = $account->getRole();
            foreach ($authorization->getRoles() as $role) {
                if (($role = $roleRepository->getByName($role)) instanceof Role) {
                    if ($accountRole->isAllowed($role)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param $message
     * @param array $params
     * @return string
     */
    protected function trans($message, array $params = []) {
        return $this->container->get('translator')->trans($message, $params);
    }
}