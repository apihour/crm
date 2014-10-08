<?php

namespace Apihour\ContractorBundle\DataGrid\Contractor;

use Tutto\CommonBundle\Tools\RouteDefinition;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Column;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\HtmlTagDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\RouteDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder\GridBuilderInterface;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;
use Apihour\FrontendBundle\DataGrid\Grid\Column\EditableColumn;

/**
 * Class Grid
 * @package Apihour\ContractorBundle\DataGrid\Contractor
 */
class Grid implements GridInterface {
    /**
     * @param GridBuilderInterface $builder
     * @return void
     */
    public function appendSettings(GridBuilderInterface $builder)
    {
        $builder->addAttribute('class', 'table table-striped table-hover');


    }
} 