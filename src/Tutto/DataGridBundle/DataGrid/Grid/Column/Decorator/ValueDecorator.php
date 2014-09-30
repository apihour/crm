<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Tutto\XhtmlBundle\Lib\SimpleText;

/**
 * Class ValueDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class ValueDecorator extends AbstractDecorator {
    /**
     * @return SimpleText
     */
    public function decorate() {
        return new SimpleText($this->getValue());
    }
}