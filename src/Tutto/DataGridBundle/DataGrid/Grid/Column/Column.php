<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\ValueDecorator;

/**
 * Class Column
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 */
class Column extends AbstractColumn {
    /**
     * @param $name
     * @param array $options
     */
    function __construct($name, array $options = []) {
        $options['decorators'] = [[
            [new ValueDecorator(), self::APPEND]
        ]];

        parent::__construct($name, $options);
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'column';
    }
}