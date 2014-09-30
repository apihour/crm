<?php

namespace Apihour\UserBundle\DataGrid\UserAccount;

use Tutto\CommonBundle\Tools\RouteDefinition;
use Tutto\DataGridBundle\DataGrid\Grid\Column\CheckboxColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Column;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\HtmlTagDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\Event;
use Tutto\DataGridBundle\DataGrid\Grid\Column\LinkedColumn;
use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder\GridBuilderInterface;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;
use Tutto\XhtmlBundle\Lib\Tag;

/**
 * Class Grid
 * @package Apihour\UserBundle\DataGrid\Grid
 */
class Grid implements GridInterface {

    /**
     * @param GridBuilderInterface $builder
     * @return void
     */
    public function appendSettings(GridBuilderInterface $builder) {
        $builder->addAttribute('class', 'table table-striped table-hover');

        $buttonColumn = new LinkedColumn(
            'id',
            new RouteDefinition(
                $builder->getRouter(),
                'apihour_user_account_switch',
                ['id' => 'id']
            ),
            [
                'label'        => 'select_account',
                'propertyPath' => false,
                'staticValue'  => $builder->getContainer()->get('translator')->trans('select_account')
            ]
        );

        $buttonColumn->addDecorator(new HtmlTagDecorator('button', ['class' => 'btn btn-blue']));

        $roleColumn = new Column('role', [
            'label' => 'role',
            'propertyPath' => 'role.name'
        ]);

        $checkboxesColumn = new CheckboxColumn();

        $builder->addColumn($checkboxesColumn);
        $builder->addColumn($buttonColumn);
        $builder->addColumn($roleColumn);
    }
}