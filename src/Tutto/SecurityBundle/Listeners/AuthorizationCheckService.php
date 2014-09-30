<?php

namespace Tutto\SecurityBundle\Listeners;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Tutto\SecurityBundle\Configuration\Authorization;
use Tutto\SecurityBundle\Listeners\Authorization\UserNotLoggedException;
use Tutto\SecurityBundle\Listeners\Authorization\PermissionDeniedException;

use LogicException;
use ReflectionObject;
use ReflectionMethod;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Entity\User;
use Tutto\SecurityBundle\Repository\RoleRepository;

/**
 * Class AuthorizationCheckService
 * @package Tutto\SecurityBundle\Service
 */
class AuthorizationCheckService extends AbstractContainerAware {
    /**
     * @param FilterControllerEvent $event
     * @return void
     * @throws PermissionDeniedException
     * @throws UserNotLoggedException
     */
    public function init(FilterControllerEvent $event) {
        if (!$event->isMasterRequest()) {
            return ;
        }

        if (!isset($event->getController()[0]) || !isset($event->getController()[1])) {
            throw new LogicException("This is not controller");
        }

        $controller = $event->getController()[0];
        $action     = $event->getController()[1];
        $reader     = new AnnotationReader();

        // Sprawdzamy najpierw czy użytkownik ma dostęp do akcji kontrolera.
        $annotation = $reader->getMethodAnnotation(new ReflectionMethod($controller, $action), Authorization::class);
        if ($annotation) {
            if ($this->checkAuthorization($annotation)) {
                return ;
            } else {
                throw new PermissionDeniedException($this->trans('exceptions:permissionDenied'));
            }
        }

        // Jeśli akcja nie posiada adnotacji to sprawdzamy czy ma dostęp do kontrolera.
        $annotation = $reader->getClassAnnotation(new ReflectionObject($controller), Authorization::class);
        if ($annotation) {
            if ($this->checkAuthorization($annotation)) {
                return ;
            } else {
                throw new PermissionDeniedException($this->trans('exceptions:permissionDenied'));
            }
        }

        // Jeśli kontroler i akcja nie posiadają adnotacji - rzucamy wyjątek.
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
     * @param Authorization $authorization
     * @throws UserNotLoggedException
     * @return boolean
     */
    public function checkAuthorization(Authorization $authorization) {
        if ($authorization->isOmit()) {
            return true;
        }

        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new UserNotLoggedException($this->trans('exceptions:userNotLogged'));
        }

        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(Role::class);
        $userRole       = $user->getRole();
        foreach ($authorization->getRoles() as $role) {
            if (($role = $roleRepository->getByName($role)) instanceof Role) {
                if ($userRole->isAllowed($role)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $message
     * @param array $params
     * @return mixed
     */
    protected function trans($message, array $params = []) {
        return $this->get('translator')->trans($message, $params);
    }
} 