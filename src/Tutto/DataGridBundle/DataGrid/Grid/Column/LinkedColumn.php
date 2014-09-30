<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;
use Tutto\CommonBundle\Tools\RouteDefinition;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\HtmlTagDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\RouteDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\ValueDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\Event;
use Tutto\XhtmlBundle\Lib\SimpleText;
use Tutto\XhtmlBundle\Lib\Tag;

/**
 * Class LinkedColumn
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 */
class LinkedColumn extends AbstractColumn {
    /**
     * @param string $name
     * @param RouteDefinition $routeDefinition
     * @param array $options
     * @throws Exceptions\BadPostAccessEventException
     */
    function __construct($name, RouteDefinition $routeDefinition, array $options = []) {
        $attributes = isset($options['attributes']) ? $options['attributes'] : [];

        $options['decorators'] = [[
            [new RouteDecorator($routeDefinition, $attributes), self::PREPEND],
            [new ValueDecorator(), self::APPEND]
        ]];
        parent::__construct($name, $options);
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'column_linked';
    }
}