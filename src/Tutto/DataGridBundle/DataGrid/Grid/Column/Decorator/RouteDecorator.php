<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Tutto\CommonBundle\Tools\RouteDefinition;
use Tutto\XhtmlBundle\Lib\Tag;
use Tutto\XhtmlBundle\Lib\TagInterface;

/**
 * Class RouteDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class RouteDecorator extends HtmlTagDecorator {
    /**
     * @var RouteDefinition
     */
    protected $routeDefinition;

    /**
     * @param RouteDefinition $routeDefinition
     * @param array $attributes
     * @param array $tags
     * @param array $prependTags
     */
    function __construct(RouteDefinition $routeDefinition, array $attributes = [], array $tags = [], array $prependTags = []) {
        $this->routeDefinition = $routeDefinition;
        $this->attributes      = $attributes;
        $this->tags            = $tags;
    }

    /**
     * @return TagInterface
     */
    public function decorate() {
        $attributes = array_merge_recursive(
            $this->attributes,
            ['href' => $this->routeDefinition->generate($this->getData())]
        );

        return new Tag('a', $attributes, $this->tags);
    }
}