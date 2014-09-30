<?php

namespace Apihour\UserBundle\DataGrid\UserProfiles\Contractor;


use Tutto\DataGridBundle\DataGrid\AbstractFilterType;

class FiltersType extends AbstractFilterType {
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_user_profiles_contractor';
    }
}