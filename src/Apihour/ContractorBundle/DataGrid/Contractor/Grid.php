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

        $firstnameColumn = new EditableColumn(
            'firstname',
            $builder->getRouter(),
            'apihour_contractor_changedata',
            [
                'label' => 'firstname',
                'propertyPath' => 'person.firstname',
                'type' => EditableColumn::TYPE_TEXT,
                'mode' => EditableColumn::MODE_INLINE
            ]
        );

        $editableColumn = new EditableColumn(
            'shortname',
            $builder->getRouter(),
            'apihour_contractor_changedata',
            [
                'label' => 'contractor.form.shortname',
                'type' => EditableColumn::TYPE_TEXT,
            ]
        );

        $editableColumn2 = new EditableColumn(
            'iban',
            $builder->getRouter(),
            'apihour_contractor_changedata',
            [
                'label' => 'contractor.form.iban',
                'propertyPath' => 'iban',
                'indexPath' => 'id',
                'type' => EditableColumn::TYPE_SELECT
            ],
            [
                'pl' => 'Polski',
                'en' => 'English',
                'de' => 'Deuth'
            ]
        );

        $icoEditColumn = new Column('edit');
        $icoEditColumn->addDecorator(new RouteDecorator(
            new RouteDefinition(
                $builder->getRouter(),
                'apihour_contractor_edit',
                ['id' => 'id']
            ),
            [
                'class' => 'btn btn-xs btn-blue tooltips',
                'data-placement' => 'top',
                'data-original-title' => 'edit'
            ]
        ));
        $icoEditColumn->setPropertyPath(false);
        $icoEditColumn->addDecorator(new HtmlTagDecorator('i', ['class' => 'fa fa-edit']), Column::APPEND);

        $icoDeleteColumn = new Column('delete');
        $icoDeleteColumn->addDecorator(new RouteDecorator(
            new RouteDefinition(
                $builder->getRouter(),
                'apihour_contractor_delete',
                ['id' => 'id']
            ),
            [
                'class' => 'btn btn-xs btn-red tooltips',
                'data-placement' => 'top',
                'data-original-title' => 'remove'
            ]
        ));
        $icoDeleteColumn->setPropertyPath(false);
        $icoDeleteColumn->addDecorator(new HtmlTagDecorator('i', ['class' => 'fa fa-times fa fa-white']), Column::APPEND);


        $builder->addColumn($firstnameColumn);
        $builder->addColumn($editableColumn);
        $builder->addColumn($icoEditColumn);
        $builder->addColumn($icoDeleteColumn);
        $builder->addColumn($editableColumn2);
    }
} 