<?php
/**
 * Created by PhpStorm.
 * User: pkrawczyk
 * Date: 18.09.14
 * Time: 13:24
 */

namespace Apihour\ContractorBundle\DataGrid\Contractor;


use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;

/**
 * Class FiltersType
 * @package Apihour\ContractorBundle\DataGrid\Contractor
 */
class FiltersType extends AbstractFiltersType {
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
     return "apihour_contractors_filters_type";
    }
} 