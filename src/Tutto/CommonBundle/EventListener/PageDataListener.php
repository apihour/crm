<?php

namespace Tutto\CommonBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Tutto\CommonBundle\Configuration\PageData;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use ReflectionClass;

/**
 * Class PageDataListener
 */
class PageDataListener extends AbstractContainerAware {
    /**
     * @var array
     */
    protected $defaults = [];

    /**
     * @param FilterControllerEvent $event
     */
    public function handle(FilterControllerEvent $event) {
        $controller = $event->getController()[0];
        $action     = $event->getController()[1];
        $reader     = new AnnotationReader();

        $reflectClass = new ReflectionClass($controller);
        $data         = [];

        /** @var PageData $annotation */
        $annotation = $reader->getClassAnnotation($reflectClass, PageData::class);
        if ($annotation instanceof PageData) {
            $data = array_merge($this->getDefaults(), $annotation->getData());
        }

        if ($reflectClass->hasMethod($action)) {
            $annotation = $reader->getMethodAnnotation($reflectClass->getMethod($action), PageData::class);
            if ($annotation instanceof PageData) {
                $data = array_merge($data, $annotation->getData());
            }
        }

        $this->container->get('twig')->addGlobal('page_data', $data);
    }

    /**
     * @return array
     */
    public function getDefaults() {
        return $this->defaults;
    }

    /**
     * @param array $defaults
     */
    public function setDefaults(array $defaults = []) {
        $this->defaults = $defaults;
    }
} 