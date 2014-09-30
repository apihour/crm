<?php

namespace Tutto\DataGridBundle\DataGrid\DataProvider;

/**
 * Class ArrayDataProvider
 * @package Tutto\DataGridBundle\DataGrid\DataProvider
 */
class ArrayDataProvider implements DataProviderInterface {
    /**
     * @var int
     */
    protected $limit = self::LIMIT;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var array
     */
    protected $results = [];

    /**
     * @param array $results
     */
    public function __construct(array $results = []) {
        $this->results = $results;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getResults($limit = self::LIMIT, $offset = 0) {
        return array_slice($this->results, (int) $offset, (int) $limit);
    }

    /**
     * Count elements of an object
     * @return int The custom count as an integer.
     */
    public function count() {
        return count($this->results);
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function setData($data) {
    }

    /**
     * @param int $limit
     * @return void
     */
    public function setLimit($limit = self::LIMIT) {
        $this->limit = (int) $limit;
    }

    /**
     * @param int $offset
     * @return void
     */
    public function setOffset($offset = 0) {
        $this->offset = (int) $offset;
    }

    /**
     * @return int
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }
}