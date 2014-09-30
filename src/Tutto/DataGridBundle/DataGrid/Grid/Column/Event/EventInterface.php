<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Event;

/**
 * Interface EventInterface
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Event
 */
interface EventInterface {
    /**
     * @param mixed $data
     * @return void
     */
    public function setData($data);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue($value);

    /**
     * @return mixed
     */
    public function getValue();
} 