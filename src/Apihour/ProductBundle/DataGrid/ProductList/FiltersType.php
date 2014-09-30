<?php

namespace Apihour\ProductBundle\DataGrid\ProductList;

use Symfony\Component\Form\FormBuilderInterface;
use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;

/**
 * Class FiltersType
 * @package Apihour\ProductBundle\DataGrid\ProductList
 */
class FiltersType extends AbstractFiltersType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'type',
            'choice',
            [
                'label'       => false,
                'empty_value' => 'asd',
                'required'    => false,
                'choices'     => [

                ]
            ]
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_product_list_filters_type';
    }
}