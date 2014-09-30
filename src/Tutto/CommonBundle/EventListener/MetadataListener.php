<?php

namespace Tutto\CommonBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Tutto\CommonBundle\Configuration\Metadata;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

use ReflectionClass;

/**
 * Class MetadataListener
 * @package Tutto\FrontendBundle\Services
 */
class MetadataListener extends AbstractContainerAware {
    /**
     * @var array
     */
    protected $metadata = array(
        'title'       => Metadata::DEFAULT_TITLE,
        'keywords'    => Metadata::DEFAULT_KEYWORDS,
        'description' => Metadata::DEFAULT_DESCRITPION
    );

    /**
     * @param FilterControllerEvent $event
     */
    public function handle(FilterControllerEvent $event) {
        $controller = $event->getController()[0];
        $action     = $event->getController()[1];
        $reader     = new AnnotationReader();

        $reflectClass = new ReflectionClass($controller);

        $metadataAnnotation = $reader->getClassAnnotation($reflectClass, Metadata::class);
        if($metadataAnnotation !== null) {
            $this->setMetadata($metadataAnnotation);
        }

        if($reflectClass->hasMethod($action)) {
            $metadataAnnotation = $reader->getMethodAnnotation($reflectClass->getMethod($action), Metadata::class);
            if($metadataAnnotation !== null) {
                $this->setMetadata($metadataAnnotation);
            }
        }

        $this->getContainer()->get('twig')->addGlobal('metadata', $this->metadata);
    }

    /**
     * @param Metadata $object
     */
    protected function setMetadata(Metadata $object) {
        foreach ($this->metadata as $key => $metadata) {
            $method = 'get'.ucfirst($key);
            if(is_callable(array($object, $method))) {
                $this->metadata[$key] = $object->{$method}();
            }
        }
    }
} 