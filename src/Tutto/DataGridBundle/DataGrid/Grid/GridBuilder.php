<?php

namespace Tutto\DataGridBundle\DataGrid\Grid;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Tutto\DataGridBundle\DataGrid\Grid\Action\AbstractAction;
use Tutto\DataGridBundle\DataGrid\Grid\Column\AbstractColumn;
use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder\GridBuilderInterface;
use Tutto\SecurityBundle\Entity\User;

/**
 * Class GridBuilder
 * @package Tutto\DataGridBundle\DataGrid\Grid\GridBuilder
 */
class GridBuilder extends AbstractContainerAware implements GridBuilderInterface {
    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var AbstractAction[]
     */
    protected $actions = [];

    /**
     * @param AbstractColumn $column
     */
    public function addColumn(AbstractColumn $column) {
        $this->columns[$column->getName()] = $column;
    }

    /**
     * @param string $name
     * @return AbstractColumn|null
     */
    public function getColumn($name) {
        return $this->hasColumn($name) ? $this->columns[$name] : null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasColumn($name) {
        return isset($this->columns[$name]);
    }

    /**
     * @return AbstractColumn[]
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes) {
        $this->clearAttributes();
        foreach ($attributes as $name => $value) {
            $this->addAttribute($name, $value);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function addAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null) {
        if ($this->hasAttribute($name)) {
            return $this->attributes[$name];
        } else {
            return $default;
        }
    }

    /**
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name) {
        return isset($this->attributes[$name]);
    }

    /**
     * @return void
     */
    public function clearAttributes() {
        $this->attributes = [];
    }

    /**
     * @param AbstractAction $action
     */
    public function addAction(AbstractAction $action) {
        $this->actions[] = $action;
    }

    /**
     * @return AbstractAction[]
     */
    public function getActions() {
        return $this->actions;
    }
}