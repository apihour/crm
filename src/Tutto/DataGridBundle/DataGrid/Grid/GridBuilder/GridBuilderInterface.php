<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\GridBuilder;
use Tutto\CommonBundle\DependencyInjection\ContainerAwareInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Action\AbstractAction;
use Tutto\DataGridBundle\DataGrid\Grid\Column\AbstractColumn;

/**
 * Interface GridBuilderInterface
 * @package Tutto\DataGridBundle\DataGrid\Grid
 */
interface GridBuilderInterface extends ContainerAwareInterface {
    /**
     * @param AbstractColumn $column
     * @return void
     */
    public function addColumn(AbstractColumn $column);

    /**
     * @return AbstractColumn[]
     */
    public function getColumns();

    /**
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes);

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function addAttribute($name, $value);

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null);

    /**
     * @return void
     */
    public function clearAttributes();

    /**
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name);

    /**
     * @param AbstractAction $action
     * @return void
     */
    public function addAction(AbstractAction $action);

    /**
     * @return AbstractAction[]
     */
    public function getActions();
} 