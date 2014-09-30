<?php

namespace Tutto\DataGridBundle\DataGrid\Helper;

/**
 * Class Results
 * @package Tutto\DataGridBundle\DataGrid\Helper
 */
class Results {
    /**
     * @var array
     */
    protected $results;

    /**
     * @param array $results
     */
    public function __construct(array $results) {
        $this->results = $results;
    }

    /**
     * @return array
     */
    public function results() {
        return $this->results;
    }
} 