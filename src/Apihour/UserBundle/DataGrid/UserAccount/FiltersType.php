<?php

namespace Apihour\UserBundle\DataGrid\UserAccount;

use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;

/**
 * Class FiltersType
 * @package Apihour\UserBundle\DataGrid\UserAccount
 */
class FiltersType extends AbstractFiltersType {
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_user_user_account_filters_type';
    }
}