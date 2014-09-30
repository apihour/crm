<?php

namespace Apihour\ProductBundle\DataGrid\ProductList;

use Tutto\DataGridBundle\DataGrid\Grid\Column\CheckboxColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Column;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator\Icon;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\Event;
use Tutto\DataGridBundle\DataGrid\Grid\Column\IconsColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\StatusColumn;
use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder\GridBuilderInterface;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;
use Apihour\ProductBundle\Entity\Product;

/**
 * Class Grid
 * @package Apihour\ProductBundle\DataGrid\ProductList
 */
class Grid implements GridInterface {
    /**
     * @param GridBuilderInterface $builder
     * @return void
     */
    public function appendSettings(GridBuilderInterface $builder) {
        $builder->setAttributes(['class' => ['table table-striped table-hover']]);

        $checkboxColumn = new CheckboxColumn();
        $nameColumn     = new Column('name', ['label' => 'product:name']);
        $typeColumn     = new Column('type', ['translate' => true, 'label' => 'product:type.name']);
        $priceColumn    = new Column('price', ['label' => 'product:price', 'attributes' => ['class' => 'center']]);
        $statusColumn   = new StatusColumn($builder->getContainer()->get('translator'));

        $priceColumn->addPostAccessEvent(function (Event $event) {
            /** @var Product $product */
            $product = $event->getData();
            $event->setValue(number_format($product->getPrice(), 2, '.', ',').' '.$product->getCurrency()->getCurrency());
        });


        $iconsColumn = new IconsColumn(
            $builder->getRouter(),
            'actions',
            [
                new Icon('apihour_product_edit', ['class' => 'btn btn-xs btn-blue tooltips'], ['class' => 'fa fa-edit'])
            ]
        );

        $icColumn = new \Apihour\FrontendBundle\DataGrid\Grid\Column\IconsColumn(
            $builder->getRouter(),
            $builder->getContainer()->get('translator'),
            'apihour_product'
        );

        $builder->addColumn($checkboxColumn);
        $builder->addColumn($nameColumn);
        $builder->addColumn($typeColumn);
        $builder->addColumn($priceColumn);
        $builder->addColumn($statusColumn);
        $builder->addColumn($iconsColumn);
        $builder->addColumn($icColumn);
    }
}