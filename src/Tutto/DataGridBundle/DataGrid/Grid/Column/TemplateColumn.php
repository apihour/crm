<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\TemplateDecorator;

/**
 * Class TemplateColumn
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 */
class TemplateColumn extends AbstractColumn {
    function __construct($name, EngineInterface $engine, $template, array $options = []) {
        $options['decorators'] = [[
            [new TemplateDecorator($engine, $template), self::APPEND]
        ]];
        $options['propertyPath'] = false;

        parent::__construct($name, $options);
    }


    /**
     * @return string
     */
    public function getAliasName() {
        return 'column_template';
    }
}