<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Symfony\Component\Routing\Router;

use Tutto\CommonBundle\Tools\RouteDefinition;
use Tutto\XhtmlBundle\Lib\Tag;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator\CallableEvent;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator\Icon;
use Tutto\XhtmlBundle\Lib\SimpleText;
use Tutto\XhtmlBundle\Lib\TagInterface;

/**
 * Class IconsDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class IconsDecorator extends AbstractDecorator {
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $routeDefinitionParams = ['id' => 'id'];

    /**
     * @var Icon[]
     */
    protected $icons = [];

    /**
     * @param Router $router
     * @param Icon[] $icons
     * @param array $routeDefinitionParams
     */
    function __construct(Router $router, array $icons = [], array $routeDefinitionParams = ['id' => 'id']) {
        $this->router = $router;
        $this->icons  = $icons;
    }

    /**
     * @return array|IconsDecorator\Icon[]
     */
    public function getIcons() {
        return $this->icons;
    }

    /**
     * @param Icon $icons
     */
    public function addIcon(Icon $icons) {
        $this->icons[] = $icons;
    }

    /**
     * @return array
     */
    public function getRouteDefinitionParams() {
        return $this->routeDefinitionParams;
    }

    /**
     * @param array $routeDefinitionParams
     */
    public function setRouteDefinitionParams(array $routeDefinitionParams) {
        $this->routeDefinitionParams = $routeDefinitionParams;
    }

    /**
     * @return TagInterface
     */
    public function decorate() {
        $container = new SimpleText();
        foreach ($this->icons as $icon) {
            if (is_callable($icon->getCallable())) {
                call_user_func_array($icon->getCallable(), [new CallableEvent($icon, $this->getData(), $this->getValue())]);
            }

            if ($icon->isVisible()) {
                $routeDefinition = new RouteDefinition(
                    $this->router,
                    $icon->getRouteName(),
                    $this->getRouteDefinitionParams()
                );

                $attr = array_merge_recursive(
                    ['href' => $routeDefinition->generate($this->getData())],
                    $icon->getAttr()
                );

                $a = new Tag('a', $attr, [new Tag('i', $icon->getFaAttr())]);
                $container->addChild($a);
            }
        }

        return $container;
    }
}