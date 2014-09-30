<?php

namespace Tutto\DataGridBundle\DataGrid\Helper;

use Symfony\Component\Form\FormView;

/**
 * Class FiltersType
 * @package Tutto\DataGridBundle\DataGrid\Helper
 */
class FiltersType {
    /**
     * @var FormView
     */
    protected $formView;

    /**
     * @param FormView $formView
     */
    public function __construct(FormView $formView) {
        $this->formView = $formView;
    }

    /**
     * @return FormView
     */
    public function getFiltersType() {
        return $this->formView;
    }
} 