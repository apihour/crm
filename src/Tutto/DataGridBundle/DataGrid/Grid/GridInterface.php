<?php

namespace Tutto\DataGridBundle\DataGrid\Grid;

use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder\GridBuilderInterface;

/**
 * Interface GridInterface
 * @package Tutto\DataGridBundle\DataGrid\Grid
 */
interface GridInterface {
    /**
     * @param GridBuilderInterface $builder
     * @return void
     */
    public function appendSettings(GridBuilderInterface $builder);
} 