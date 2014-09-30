<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\Exceptions\BadCallableException;
use Tutto\XhtmlBundle\Lib\TagInterface;
use Closure;

/**
 * Class CallableDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class CallableDecorator extends AbstractDecorator {
    /**
     * @var Closure $callable
     */
    protected $callable;

    /**
     * @param Closure $callable
     * @throws BadCallableException
     */
    function __construct($callable) {
        if ($callable instanceof Closure || is_callable($callable)) {
            $this->callable = $callable;
        } else {
            throw new BadCallableException("Callable: '{$callable}'.");
        }
    }

    /**
     * @return TagInterface
     */
    public function decorate() {
        return call_user_func_array($this->callable, [$this->getData(), $this->getValue()]);
    }
}