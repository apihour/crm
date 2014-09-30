<?php

namespace Tutto\DataGridBundle\DataGrid\Helper;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class GenerateRoute
 * @package Apihour\UserBundle\DataGrid\Helper
 */
class GenerateRoute extends AbstractContainerAware {
    /**
     * @param array $params
     * @param null|string $routeName
     * @return string
     */
    public function generateRoute(array $params = array(), $routeName = null, $referenceType = UrlGenerator::ABSOLUTE_PATH) {
        $routeName = $routeName === null ? $this->getRequest()->get('_route') : $routeName;

        return $this->getRouter()->generate($routeName, $params, $referenceType);
    }
} 