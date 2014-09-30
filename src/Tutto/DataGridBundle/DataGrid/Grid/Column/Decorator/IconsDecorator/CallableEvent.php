<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator;

/**
 * Class CallableEvent
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator
 */
class CallableEvent {
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var Icon
     */
    protected $icon;

    /**
     * @param Icon $icon
     * @param mixed $data
     * @param mixed $value
     */
    function __construct(Icon $icon, $data, $value) {
        $this->setIcon($icon);
        $this->setData($data);
        $this->setValue($value);
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return Icon
     */
    public function getIcon() {
        return $this->icon;
    }

    /**
     * @param Icon $icon
     */
    public function setIcon(Icon $icon) {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }
} 