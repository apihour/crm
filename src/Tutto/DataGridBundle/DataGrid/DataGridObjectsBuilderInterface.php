<?php

namespace Tutto\DataGridBundle\DataGrid;
use Tutto\DataGridBundle\DataGrid\DataProvider\DataProviderInterface;
use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;

/**
 * Interface DataGridObjectsBuilderInterface
 * @package Tutto\DataGridBundle\DataGrid
 */
interface DataGridObjectsBuilderInterface {
    /**
     * @return DataProviderInterface
     */
    public function getDataProvider();

    /**
     * @return AbstractFiltersType
     */
    public function getFiltersType();

    /**
     * @return GridInterface
     */
    public function getGrid();
} 