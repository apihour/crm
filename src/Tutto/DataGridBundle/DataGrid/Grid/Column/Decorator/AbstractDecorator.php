<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

/**
 * Class AbstractDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
abstract class AbstractDecorator implements DecoratorInterface {
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }
}