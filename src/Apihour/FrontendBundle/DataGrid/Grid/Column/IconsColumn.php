<?php

namespace Apihour\FrontendBundle\DataGrid\Grid\Column;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Tutto\CommonBundle\Entity\AbstractEntity;
use Tutto\CommonBundle\Util\Status;
use Tutto\DataGridBundle\DataGrid\Grid\Column\AbstractColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\HtmlTagDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator\Icon;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\IconsDecorator\CallableEvent;

/**
 * Class IconsColumn
 * @package Apihour\FrontendBundle\DataGrid\Grid\Column
 */
class IconsColumn extends AbstractColumn {
    function __construct(Router $router, Translator $translator, $baseRouteName, array $routeDefinitionParams = ['id' => 'id'], array $icons = [], array $options = []) {
        if (empty($icons)) {
            $baseRouteName = ltrim($baseRouteName, '_').'_';
            $icons = [
                new Icon($baseRouteName.'view', $translator->trans('tooltip.view'),['class' => 'btn btn-xs btn-green tooltips'],['class' => 'fa fa-th-large']),
                new Icon($baseRouteName.'edit', $translator->trans('tooltip.edit'),['class' => 'btn btn-xs btn-blue tooltips'],['class' => 'fa fa-pencil']),
                new Icon($baseRouteName.'suspend', $translator->trans('tooltip.suspend'),['class' => 'btn btn-xs btn-red tooltips'],['class' => 'fa fa-times'], function (CallableEvent $event) {
                    $data = $event->getData();
                    if ($data instanceof AbstractEntity) {
                        $event->getIcon()->setIsVisible($data->getStatus() === Status::ENABLED);
                    }
                }),
                new Icon($baseRouteName.'activate', $translator->trans('tooltip.activate'),['class' => 'btn btn-xs btn-orange tooltips'],['class' => 'fa fa-share'], function (CallableEvent $event) {
                    $data = $event->getData();
                    if ($data instanceof AbstractEntity) {
                        $event->getIcon()->setIsVisible($data->getStatus() === Status::DISABLED);
                    }
                })
            ];
        }

        $options['propertyPath'] = false;
        $options['decorators']   = [
            [[new IconsDecorator($router, $icons, $routeDefinitionParams), self::APPEND]],
        ];
        $options['attributes'] = [
            'class' => ['center']
        ];

        parent::__construct('actions', $options);
        $this->addDecorator(new HtmlTagDecorator('div', ['class' => 'visible-md visible-lg hidden-sm hidden-xs']));
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'apihour_frontend_icons_column';
    }
}