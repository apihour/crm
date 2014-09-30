<?php

namespace Apihour\ExampleBundle\DataGrid\Examples\One;

use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;

/**
 * Class FiltersType
 * @package Apihour\ExampleBundle\DataGrid\Examples\One
 */
class FiltersType extends AbstractFiltersType {
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_example_one_filters_type';
    }
}