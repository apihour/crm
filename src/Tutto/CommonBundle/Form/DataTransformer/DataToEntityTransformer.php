<?php

namespace Tutto\CommonBundle\Form\DataTransformer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

use ReflectionClass;
use InvalidArgumentException;

/**
 * Class IdToEntityTransformer
 * @package Tutto\CommonBundle\Form\DataTransformer
 */
class DataToEntityTransformer extends AbstractContainerAware implements DataTransformerInterface {
    /**
     * @var string
     */
    protected $class;

    /**
     * @var bool
     */
    protected $nullable = true;

    protected $properties = array();

    /**
     * @param $class
     * @param array $options
     * @param ContainerInterface $container
     */
    public function __construct($class, $options = array(), ContainerInterface $container = null) {
        $this->setClass($class);
        $this->setContainer($container);

        foreach ((array) $options as $key => $val) {
            if(is_string($key)) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function transform($value) {
        if($value === null || !is_object($value)) {
            return array();
        }

        $data         = array();
        $ReflectClass = new ReflectionClass($this->class);

        foreach($ReflectClass->getProperties() as $property) {
            if($property->isPublic() && !$property->isStatic()) {
                $data[$property->getName()] = $value->{$property->getName()};
            } else {
                $methodName = 'get'.ucfirst($property->getName());
                if($ReflectClass->hasMethod($methodName) &&
                   (($method = $ReflectClass->getMethod($methodName)) &&
                    $method->isPublic())
                ) {
                    $data[$property->getName()] = $value->{$methodName}();
                }
            }
        }

        return $data;
    }

    /**
     * @param mixed $value
     * @return mixed|null|object
     */
    public function reverseTransform($value) {
        if(empty($value)) {
            return null;
        }

        $findBy = array();
        foreach ($this->properties as $property) {
            if(isset($value[$property])) {
                $findBy[$property] = $value[$property];
            }
        }

        if(empty($findBy)) {
            return null;
        }

        $results = $this->getRepository($this->class)->findOneBy($findBy);
        if($results === null && !$this->nullable) {
            throw new InvalidArgumentException("Results can not be null.");
        }

        return $results;
    }

    /**
     * @param $class
     */
    private function setClass($class) {
        if(!is_object($class) && !(is_string($class) && class_exists($class))) {
            throw new \LogicException("Class: '{$class}' not exists.");
        }

        if(is_object($class)) {
            $class = get_class($class);
        }

        $this->class = $class;
    }
}