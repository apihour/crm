<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;

use Symfony\Component\Routing\Router;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator\Icon;

/**
 * Class IconsColumn
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 */
class IconsColumn extends AbstractColumn {
    /**
     * @param string $name
     * @param Router $router
     * @param array $icons
     * @param Icon[] $options
     */
    function __construct(Router $router, $name = 'actions', array $icons = [], array $options = []) {
        $options['decorator']    = [new IconsDecorator($router, $icons), self::PREPEND];
        $options['propertyPath'] = false;

        parent::__construct($name, $options);
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'icons_column';
    }
}