<?php

namespace Tutto\DataGridBundle\DataGrid\Helper;

use Closure;

/**
 * Class Helper
 * @package Tutto\DataGridBundle\DataGrid\Helper
 */
class Helper {
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Closure
     */
    protected $callable;

    /**
     * @param string $name
     * @param $callable
     */
    public function __construct($name, $callable) {
        $this->name     = $name;
        $this->callable = $callable;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return Closure
     */
    public function getCallable() {
        return $this->callable;
    }
} 