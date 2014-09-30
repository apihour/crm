<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator;

use Closure;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\Exceptions\BadCallableException;

/**
 * Class Icon
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator
 */
class Icon {
    protected $routeName;
    protected $attr = [];
    protected $callable = null;
    protected $isVisible = true;
    protected $faAttr = [];

    public function __construct($routeName, $tooltip = false, array $attr = [], array $faAttr = [], $callable = null) {
        if (!empty($tooltip)) {
            $attr = array_merge_recursive(
                [
                    'data-original-title' => $tooltip,
                    'data-placement'      => 'top'
                ],
                $attr
            );
        }

        $this->setRouteName($routeName);
        $this->setFaAttr($faAttr);
        $this->setAttr($attr);
        $this->setCallable($callable);
    }

    public function setCallable($callable) {
        if ($callable === null || ($callable instanceof Closure || is_callable($callable))) {
            $this->callable = $callable;
        } else {
            throw new BadCallableException('Variable: '.gettype($callable).' is not callable.');
        }
    }

    public function getCallable() {
        return $this->callable;
    }

    public function isVisible() {
        return $this->isVisible;
    }

    public function setIsVisible($isVisible) {
        $this->isVisible = (boolean) $isVisible;
    }

    public function getAttr() {
        return $this->attr;
    }

    public function setAttr(array $attr) {
        $this->attr = $attr;
    }

    public function getFaAttr() {
        return $this->faAttr;
    }

    public function setFaAttr(array $faAttr) {
        $this->faAttr = $faAttr;
    }

    /**
     * @return mixed
     */
    public function getRouteName() {
        return $this->routeName;
    }

    /**
     * @param mixed $routeName
     */
    public function setRouteName($routeName) {
        $this->routeName = $routeName;
    }
}