<?php

namespace Tutto\CommonBundle\Tools;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class RouteDefinition
 * @package Tutto\CommonBundle\Tools
 */
class RouteDefinition {
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var array
     */
    protected $routeDefinitionParams = [];

    /**
     * @var array
     */
    protected $additionalRouteParams = [];

    /**
     * @var bool
     */
    protected $type = UrlGeneratorInterface::ABSOLUTE_PATH;


    /**
     * @param Router $router
     * @param $routeName
     * @param array $routeDefinitionParams
     * @param array $additionalRouteParams
     * @param bool $type
     */
    public function __construct(Router $router, $routeName, array $routeDefinitionParams = [], array $additionalRouteParams = [], $type = UrlGeneratorInterface::ABSOLUTE_PATH) {
        $this->setRouter($router);
        $this->setRouteName($routeName);
        $this->setRouteDefinitionParams($routeDefinitionParams);
        $this->setAdditionalRouteParams($additionalRouteParams);
        $this->setType($type);
    }

    /**
     * @param array $data
     * @return string
     */
    public function generate($data = null) {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $routeParams = [];
        foreach ($this->getRouteDefinitionParams() as $key => $value) {
            if (is_array($data)) {
                $value = '['.trim($value, '[]').']';
            }
            $routeParams[$key] = $propertyAccessor->getValue($data, $value);
        }

        $routeParams = array_merge($this->getAdditionalRouteParams(), $routeParams);

        return $this->getRouter()->generate($this->getRouteName(), $routeParams, $this->getType());
    }

    /**
     * @return array
     */
    public function getAdditionalRouteParams() {
        return $this->additionalRouteParams;
    }

    /**
     * @param array $additionalRouteParams
     */
    public function setAdditionalRouteParams($additionalRouteParams) {
        $this->additionalRouteParams = $additionalRouteParams;
    }

    /**
     * @return string
     */
    public function getRouteName() {
        return $this->routeName;
    }

    /**
     * @param string $routeName
     */
    public function setRouteName($routeName) {
        $this->routeName = $routeName;
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
    public function setRouteDefinitionParams(array $routeDefinitionParams = []) {
        $this->routeDefinitionParams = $routeDefinitionParams;
    }

    /**
     * @return boolean
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param boolean $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return Router
     */
    public function getRouter() {
        return $this->router;
    }

    /**
     * @param Router $router
     */
    public function setRouter($router) {
        $this->router = $router;
    }
}