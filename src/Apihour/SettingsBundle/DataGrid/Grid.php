<?php

namespace Apihour\SettingsBundle\DataGrid;

use Apihour\FrontendBundle\DataGrid\Grid\Column\EditableColumn;
use Apihour\FrontendBundle\DataGrid\Grid\Column\IconsColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Column;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator\Icon;
use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder\GridBuilderInterface;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;

/**
 * Class Grid
 * @package Apihour\SettingsBundle\DataGrid
 */
class Grid implements GridInterface {
    /**
     * @var string
     */
    protected $editRouteName;

    /**
     * @var string
     */
    protected $createRouteName;

    /**
     * @param string $editRouteName
     * @param string $createRouteName
     */
    function __construct($editRouteName, $createRouteName) {
        $this->editRouteName   = $editRouteName;
        $this->createRouteName = $createRouteName;
    }

    /**
     * @param GridBuilderInterface $builder
     * @return void
     */
    public function appendSettings(GridBuilderInterface $builder) {
        $builder->addAttribute('class', 'table table-striped table-hover');

        $shortDescriptionColumn = new EditableColumn(
            'shortDescription',
            $builder->getRouter(),
            'apihour_admin_option_changedata',
            [
                'label' => 'account_options:shortDescription',
                'type' => EditableColumn::TYPE_TEXT,
                'mode' => EditableColumn::MODE_INLINE
            ]
        );

        $translator = $builder->getContainer()->get('translator');

        $actionsColumn = new IconsColumn(
            $builder->getRouter(),
            $translator,
            null,
            ['id' => 'id'],
            [
                new Icon($this->editRouteName, $translator->trans('tooltip.edit'),['class' => 'btn btn-xs btn-blue tooltips'],['class' => 'fa fa-pencil']),
                new Icon($this->createRouteName, $translator->trans('tooltip.copy'),['class' => 'btn btn-xs btn-azure tooltips'],['class' => 'fa fa-copy']),
            ]
        );

        $groupColumn = new Column('group', [
            'label' => 'account_options:group'
        ]);


        $nameColumn = new Column('name', [
            'label' => 'account_options:name'
        ]);

        $defaultColumn = new EditableColumn(
            'default',
            $builder->getRouter(),
            'apihour_admin_option_changedata',
            [
                'label' => 'account_options:value',
                'type'  => EditableColumn::TYPE_TEXT,
                'mode'  => EditableColumn::MODE_INLINE
            ]
        );

        $typeColumn = new EditableColumn(
            'type',
            $builder->getRouter(),
            'apihour_admin_option_changedata',
            [
                'label' => 'account_options:type',
                'type'  => EditableColumn::TYPE_SELECT,
                'mode'  => EditableColumn::MODE_POPUP,
                'placement' => EditableColumn::PLACEMENT_LEFT
            ],
            [
                'text'     => 'text',
                'textarea' => 'textarea',
                'choice'   => 'choice'
            ]
        );

        $builder->addColumn($shortDescriptionColumn);
        $builder->addColumn($groupColumn);
        $builder->addColumn($nameColumn);
        $builder->addColumn($defaultColumn);
        $builder->addColumn($typeColumn);
        $builder->addColumn($actionsColumn);
    }
} 