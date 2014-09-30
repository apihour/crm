<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Event;
use Tutto\DataGridBundle\DataGrid\Grid\Column\AbstractColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\CheckboxDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Column;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\DecoratorInterface;
use Tutto\XhtmlBundle\Lib\AbstractTag;
use Tutto\XhtmlBundle\Lib\SimpleText;
use Tutto\XhtmlBundle\Lib\Tag;
use Tutto\XhtmlBundle\Lib\TagInterface;

/**
 * Class Event
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Event
 */
class Event implements EventInterface {
    protected $data;
    protected $value;

    /**
     * @var AbstractColumn
     */
    protected $column;

    /**
     * @param mixed $data
     * @param mixed $value
     * @param AbstractColumn $column
     */
    public function __construct($data, $value, AbstractColumn $column) {
        $this->setData($data);
        $this->setValue($value);
        $this->setColumn($column);
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * @return AbstractColumn
     */
    public function getColumn() {
        return $this->column;
    }

    /**
     * @param AbstractColumn $column
     */
    public function setColumn(AbstractColumn $column) {
        $this->column = $column;
    }

    /**
     * @return TagInterface
     */
    public function decorate() {
        if (($decorators = $this->getColumn()->getDecorators()) != null) {
            /**
             * @var DecoratorInterface $decorator
             */
            foreach ($decorators as list($decorator, $wrap)) {
                $decorator->setValue($this->getValue());
                $decorator->setData($this->getData());

                /** @var TagInterface $tag */
                if (isset($tag)) {
                    if ($wrap === Column::PREPEND) {
                        $old = $tag;
                        $tag = $decorator->decorate();
                        $tag->addChild($old);
                    } else {
                        $tag->addChild($decorator->decorate());
                    }
                } else {
                    $tag = $decorator->decorate();
                    if (is_scalar($tag)) {
                        $tag = new SimpleText($tag);
                    }
                }
            }
        } else {
            $tag = new SimpleText($this->getValue());
        }

        return $tag;
    }
}