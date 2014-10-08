<?php

namespace Apihour\SettingsBundle\DataGrid;

use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;

/**
 * Class FiltersType
 * @package Apihour\SettingsBundle\DataGrid
 */
class FiltersType extends AbstractFiltersType {
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_settings_datagrid_filters_type';
    }
}