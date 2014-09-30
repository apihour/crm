<?php

namespace Tutto\DataGridBundle\DataGrid\Helper;

use Symfony\Component\HttpFoundation\Request;
use Tutto\DataGridBundle\DataGrid\DataProvider\DataProviderInterface;

/**
 * Class Pagination
 * @package Tutto\DataGridBundle\DataGrid\Helper
 */
class Paginator {
    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var int
     */
    protected $limit = DataProviderInterface::LIMIT;

    /**
     * @var int|null
     */
    protected $previous = null;

    /**
     * @var int|null
     */
    protected $next = null;

    /**
     * @var int
     */
    protected $current = 1;

    /**
     * @var int
     */
    protected $pages = 0;

    /**
     * @param DataProviderInterface $dataProvider
     * @param Request $request
     */
    public function __construct(DataProviderInterface $dataProvider, Request $request) {
        $this->current = $request->get('page', 1);
        $this->count   = $dataProvider->count();
        $this->limit   = $dataProvider->getLimit();

        $this->pages = (int) ceil($this->count/$this->limit);

        $this->current  = $this->current > $this->pages ? $this->pages : $this->current;
        $this->current  = $this->current < 1 ? 1 : $this->current;

        $this->next     = $this->current < $this->pages ? $this->current+1 : null;
        $this->previous = $this->current > 1 ? $this->current-1  : null;
    }

    public function paginator() {
        return $this;
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getNext() {
        return $this->next;
    }

    /**
     * @return int|null
     */
    public function getPrevious() {
        return $this->previous;
    }

    /**
     * @return int
     */
    public function getCurrent() {
        return $this->current;
    }

    /**
     * @return int
     */
    public function getPages() {
        return $this->pages;
    }
} 