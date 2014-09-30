<?php

namespace Apihour\ExampleBundle\DataGrid\Examples\One;

use Tutto\CommonBundle\Tools\RouteDefinition;
use Tutto\DataGridBundle\DataGrid\Grid\Column\CheckboxColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\CollectionColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Column;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\HtmlTagDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\RouteDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\LinkedColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\TemplateColumn;
use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder\GridBuilderInterface;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;

/**
 * Class Grid
 * @package Apihour\ExampleBundle\DataGrid\Examples\One
 */
class Grid implements GridInterface {
    /**
     * @param GridBuilderInterface $builder
     * @return void
     */
    public function appendSettings(GridBuilderInterface $builder) {
        $builder->addAttribute('class', 'table table-striped table-hover');

        $checkboxesColumn = new CheckboxColumn('checkboxes');

        $nameColumn = new Column('name', [
            'label' => 'messages:firstname'
        ]);
        $nameColumn->addDecorator(new HtmlTagDecorator('b'));

        $surnameColumn = new Column('surname', [
            'label' => 'messages:lastname'
        ]);
        $surnameColumn->addDecorator(new HtmlTagDecorator('i'));
        $surnameColumn->addDecorator(new HtmlTagDecorator('u'));

        $emailColumn = new LinkedColumn(
            'email',
            new RouteDefinition(
                $builder->getRouter(),
                'apihour_examples_datagrids_one',
                [
                    'id' => 'id'
                ]
            )
        );

        $templateColumn = new TemplateColumn(
            'template',
            $builder->getContainer()->get('templating'),
            '@ApihourExample/DataGrid/_template.html.twig',
            [
                'attributes' => [
                    'class' => 'center'
                ]
            ]
        );

        $icoEditColumn = new Column('edit');
        $icoEditColumn->addDecorator(new RouteDecorator(
            new RouteDefinition(
                $builder->getRouter(),
                'apihour_examples_datagrids_one',
                ['id' => 'id']
            ),
            [
                'class' => 'btn btn-xs btn-blue tooltips',
                'data-placement' => 'top',
                'data-original-title' => 'edit'
            ]
        ));
        $icoEditColumn->addDecorator(new HtmlTagDecorator('i', ['class' => 'fa fa-edit']), Column::APPEND);

        $icoViewColumn = new LinkedColumn(
            'view',
            new RouteDefinition(
                $builder->getRouter(),
                'apihour_examples_datagrids_one',
                ['id' => 'id']
            ),
            [
                'propertyPath' => false,
                'staticValue' => 'Kliknij w link'
            ]
        );

        $collectionColumn = new CollectionColumn('accounts', 'name');

        $builder->addColumn($checkboxesColumn);
        $builder->addColumn($nameColumn);
        $builder->addColumn($surnameColumn);
        $builder->addColumn($emailColumn);
        $builder->addColumn($templateColumn);
        $builder->addColumn($icoEditColumn);
        $builder->addColumn($icoViewColumn);
        $builder->addColumn($collectionColumn);
    }
}