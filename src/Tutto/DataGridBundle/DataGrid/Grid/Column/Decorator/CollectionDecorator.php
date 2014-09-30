<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Tutto\CommonBundle\PropertyAccess\PropertyAccessor;
use Tutto\XhtmlBundle\Lib\SimpleText;
use Tutto\XhtmlBundle\Lib\Tag;
use Traversable;
use LogicException;

/**
 * Class CollectionDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class CollectionDecorator extends HtmlTagDecorator {
    protected $propertyPath;

    public function __construct($propertyPath, array $attributes = [], array $tags = []) {
        $this->attributes = $attributes;
        $this->tags       = $tags;
        $this->propertyPath = $propertyPath;
    }


    public function decorate() {
        if (is_array($this->getValue()) || $this->getValue() instanceof Traversable) {
            $ul = new Tag('ul', $this->attributes, $this->tags);
            $accessor = new PropertyAccessor();
            foreach ($this->getValue() as $object) {
                $value = $accessor->getValue($object, $this->propertyPath);
                $li = new Tag('li', [], [new SimpleText($value)]);
                $ul->addChild($li);
            }

            return $ul;
        }

        throw new LogicException('Object: '.gettype($this->getValue()).' is not iterable object (only arrays or Traversable).');
    }
} 