<?php

namespace Tutto\DataGridBundle\DataGrid\DataProvider;

use Countable;


/**
 * Interface DataProviderInterface
 * @package Tutto\DataGridBundle\DataGrid\DataProvider
 */
interface DataProviderInterface extends Countable {
    const LIMIT = 50;

    /**
     * @return array
     */
    public function getResults();

    /**
     * @param mixed $data
     * @return void
     */
    public function setData($data);

    /**
     * @param int $limit
     * @return void
     */
    public function setLimit($limit = self::LIMIT);

    /**
     * @param int $offset
     * @return void
     */
    public function setOffset($offset = 0);

    /**
     * @return int
     */
    public function getLimit();

    /**
     * @return int
     */
    public function getOffset();
} 