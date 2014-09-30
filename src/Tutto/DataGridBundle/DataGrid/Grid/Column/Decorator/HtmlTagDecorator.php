<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Tutto\XhtmlBundle\Lib\Tag;
use Tutto\XhtmlBundle\Lib\TagInterface;

/**
 * Class HtmlTagDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class HtmlTagDecorator extends AbstractDecorator {
    /**
     * @var string
     */
    protected $tagName;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var TagInterface[]
     */
    protected $tags = [];

    /**
     * @param string $tagName
     * @param array $attributes
     * @param TagInterface[] $tags
     */
    public function __construct($tagName, array $attributes = [], array $tags = []) {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->tags = $tags;
    }

    /**
     * @return Tag
     */
    public function decorate() {
        return new Tag($this->tagName, $this->attributes, $this->tags);
    }
}