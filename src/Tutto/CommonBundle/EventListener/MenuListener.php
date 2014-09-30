<?php

namespace Tutto\CommonBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Tutto\CommonBundle\Configuration\Menu;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

use ReflectionClass;

/**
 * Class MenuListener
 * @package Tutto\CommonBundle\Services
 */
class MenuListener extends AbstractContainerAware {
    /**
     * @param FilterControllerEvent $event
     */
    public function handle(FilterControllerEvent $event) {
        $controller = $event->getController()[0];
        $action     = $event->getController()[1];

        $reader       = new AnnotationReader();
        $reflectClass = new ReflectionClass($controller);

        $menu = Menu::DEFAULT_MENU;
        $menuAnnotation = $reader->getClassAnnotation($reflectClass, Menu::class);
        if($menuAnnotation !== null) {
            $menu = $menuAnnotation->getMenu();
        }

        if($reflectClass->hasMethod($action)) {
            $menuAnnotation = $reader->getMethodAnnotation($reflectClass->getMethod($action), Menu::class);
            if($menuAnnotation !== null) {
                $menu = $menuAnnotation->getMenu();
            }
        }

        $this->getContainer()->get('twig')->addGlobal('menu', $menu);
    }
} 