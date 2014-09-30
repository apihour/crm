<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Symfony\Component\Routing\Router;

use Tutto\CommonBundle\PropertyAccess\PropertyAccessor;
use Tutto\CommonBundle\Tools\RouteDefinition;
use Tutto\XhtmlBundle\Lib\Tag;

/**
 * Class EditableColumnDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class EditableColumnDecorator extends HtmlTagDecorator {
    /**
     * @var string
     */
    protected $indexPath;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @param string $tagName
     * @param string $indexPath
     * @param array $attributes
     * @param array $tags
     */
    public function __construct($tagName, Router $router, $routeName, $indexPath = 'id', array $attributes = [], array $tags = []) {
        $this->indexPath = $indexPath;
        $this->router    = $router;
        $this->routeName = $routeName;
        parent::__construct($tagName, $attributes, $tags);
    }

    /**
     * @return Tag
     */
    public function decorate() {
        $accessor       = new PropertyAccessor();
        $routeDefiniton = new RouteDefinition($this->router, $this->routeName, [$this->indexPath => $this->indexPath]);

        $this->attributes['data-pk']  = $accessor->getValue($this->getData(), $this->indexPath);
        $this->attributes['data-url'] = $routeDefiniton->generate($this->getData());
        return new Tag($this->tagName, $this->attributes, $this->tags);
    }
} 