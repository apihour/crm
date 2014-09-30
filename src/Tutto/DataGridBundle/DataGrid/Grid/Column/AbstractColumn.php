<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\DecoratorInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\PostAccessEventInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Exceptions\BadPostAccessEventException;
use Closure;

/**
 * Class AbstractColumn
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 *
 * @Annotation
 */
abstract class AbstractColumn {
    const APPEND  = 'append';
    const PREPEND = 'prepend';

    /**
     * @var string
     */
    protected $label;

    /**
     * @var array
     */
    protected $labelAttributes = [];

    /**
     * @var string
     */
    protected $propertyPath;

    /**
     * @var string
     */
    protected $staticValue;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var bool
     */
    protected $isVisible = true;

    /**
     * @var bool
     */
    protected $isSortable = false;

    /**
     * @var DecoratorInterface[]
     */
    protected $decorators = [];

    /**
     * @var array
     */
    protected $postAccessEvents = [];

    /**
     * @var bool
     */
    protected $translate = false;

    /**
     * @param $name
     * @param array $options
     */
    function __construct($name, array $options = []) {
        $this->setName($name);

        if (!isset($options['label'])) {
            $options['label'] = $name;
        }

        if (!isset($options['propertyPath'])) {
            $options['propertyPath'] = $name;
        }

        foreach ($options as $key => $values) {
            $setMethod = 'set'.ucfirst($key);
            $addMethod = 'add'.ucfirst($key);

            $values = (array) $values;
            if (is_string(key($values))) {
                $values[0] = $values;
                unset($values[key($values)]);
            }

            if (is_callable([$this, $setMethod])) {
                call_user_func_array([$this, $setMethod], $values);
            } elseif (is_callable([$this, $addMethod])) {
                call_user_func_array([$this, $addMethod], $values);
            }
        }
    }

    /**
     * @return string
     */
    abstract public function getAliasName();

    /**
     * @return string
     */
    public function getPropertyPath() {
        return $this->propertyPath;
    }

    /**
     * @param string $propertyPath
     */
    public function setPropertyPath($propertyPath) {
        $this->propertyPath = $propertyPath;
    }

    /**
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes) {
        $this->clearAttributes();
        foreach ($attributes as $name => $value) {
            $this->addAttribute($name, $value);
        }
    }

    public function hasAttribute($name) {
        return isset($this->attributes[$name]);
    }

    /**
     * @param $name
     * @param $value
     */
    public function addAttribute($name, $value) {
        if ($this->hasAttribute($name)) {
            $this->attributes[$name][] = $value;
        } else {
            $this->attributes[$name] = (array) $value;
        }
    }

    /**
     * @return void
     */
    public function clearAttributes() {
        $this->attributes = [];
    }

    /**
     * @param array $attributes
     */
    public function setLabelAttributes(array $attributes) {
        $this->clearAttributes();
        foreach ($attributes as $name => $value) {
            $this->addLabelAttribute($name, $value);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function addLabelAttribute($name, $value) {
        $this->labelAttributes[$name] = $value;
    }

    /**
     * @return array
     */
    public function getLabelAttributes() {
        return $this->labelAttributes;
    }

    /**
     * @return void
     */
    public function clearLabelAttributes() {
        $this->labelAttributes = [];
    }

    /**
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label) {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStaticValue() {
        return $this->staticValue;
    }

    /**
     * @param string $staticValue
     */
    public function setStaticValue($staticValue) {
        $this->staticValue = $staticValue;
    }

    /**
     * @return boolean
     */
    public function isTranslate() {
        return $this->translate;
    }

    /**
     * @param boolean $translate
     */
    public function setTranslate($translate) {
        $this->translate = $translate;
    }

    /**
     * @param $event
     * @throws BadPostAccessEventException
     */
    public function addPostAccessEvent($event) {
        if ($event instanceof PostAccessEventInterface || $event instanceof Closure) {
            $this->postAccessEvents[] = $event;
        } else {
            throw new BadPostAccessEventException();
        }
    }

    /**
     * @return Closure[]|PostAccessEventInterface[]
     */
    public function getPostAccessEvents() {
        return $this->postAccessEvents;
    }

    /**
     * @param DecoratorInterface $decorator
     * @param string $wrap
     */
    public function addDecorator(DecoratorInterface $decorator, $wrap = self::PREPEND) {
        $this->decorators[] = [$decorator, $wrap];
    }

    /**
     * @param DecoratorInterface $decorator
     * @param string $wrap
     */
    public function setDecorator(DecoratorInterface $decorator, $wrap = self::PREPEND) {
        $this->decorators = [[$decorator, $wrap]];
    }

    /**
     * @param array $decorators
     */
    public function setDecorators(array $decorators) {
        $this->decorators = [];

        /**
         * @var DecoratorInterface $decorator
         * @var string $wrap
         */
        foreach ($decorators as list($decorator, $wrap)) {
            $this->addDecorator($decorator, $wrap);
        }
    }

    /**
     * @return DecoratorInterface[]
     */
    public function getDecorators() {
        return $this->decorators;
    }
}