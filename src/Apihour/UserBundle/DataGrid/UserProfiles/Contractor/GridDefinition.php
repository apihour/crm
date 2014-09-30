<?php

namespace Apihour\UserBundle\DataGrid\UserProfiles\Contractor;


use Tutto\DataGridBundle\DataGrid\Grid\Builder\GridDefinitionBuilderInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Builder\GridDefinitionInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Column\CheckboxColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Column;

class GridDefinition implements GridDefinitionInterface {
    /**
     * @param GridDefinitionBuilderInterface $builder
     * @return void
     */
    public function appendDefinitions(GridDefinitionBuilderInterface $builder) {
        $builder->setAttribute('class', 'table-striped table-hover');

        $checkboxesColumn = new CheckboxColumn();
        $checkboxesColumn->addAttribute('class', 'checkbox-table');

        $builder->addColumn($checkboxesColumn);
    }
}