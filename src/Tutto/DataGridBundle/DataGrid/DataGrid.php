<?php

namespace Tutto\DataGridBundle\DataGrid;
use Symfony\Component\Form\FormInterface;
use Tutto\DataGridBundle\DataGrid\DataProvider\DataProviderInterface;
use Tutto\DataGridBundle\DataGrid\Exceptions\HelperNotFoundException;
use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;
use Tutto\DataGridBundle\DataGrid\Helper\Helper;

/**
 * Class DataGrid
 * @package Tutto\DataGridBundle\DataGrid
 */
class DataGrid {
    /**
     * @var array
     */
    protected $helpers = [];

    /**
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     */
    function __call($name, $arguments) {
        if (array_key_exists($name, $this->helpers)) {
            return call_user_func_array($this->helpers[$name], (array) $arguments);
        } else {
            throw new HelperNotFoundException("Helper: '{$name}' not found.");
        }
    }

    /**
     * @param Helper $helper
     */
    public function addHelper(Helper $helper) {
        $this->helpers[$helper->getName()] = $helper->getCallable();
    }

    /**
     * @return Helper[]
     */
    public function getHelpers() {
        return $this->helpers;
    }
} 