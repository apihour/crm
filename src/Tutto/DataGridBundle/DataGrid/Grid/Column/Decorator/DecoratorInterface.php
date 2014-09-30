<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\EventInterface;
use Tutto\XhtmlBundle\Lib\TagInterface;

/**
 * Interface DecoratorInterface
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
interface DecoratorInterface extends EventInterface {
    /**
     * @return TagInterface
     */
    public function decorate();
} 