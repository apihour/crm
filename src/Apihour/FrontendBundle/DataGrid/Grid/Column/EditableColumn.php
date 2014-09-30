<?php

namespace Apihour\FrontendBundle\DataGrid\Grid\Column;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Tutto\DataGridBundle\DataGrid\Grid\Column\AbstractColumn;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\EditableColumnDecorator;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\ValueDecorator;

/**
 * Class EditableColumn
 * @package Apihour\ContractorBundle\DataGrid\Contractor\Column
 */
class EditableColumn extends AbstractColumn {
    const TYPE_TEXT      = 'text';
    const TYPE_TEXTAREA  = 'textarea';
    const TYPE_SELECT    = 'select';
    const TYPE_DATE      = 'date';
    const TYPE_CHECKLIST = 'checklist';

    const PLACEMENT_TOP   = 'top';
    const PLACEMENT_RIGHT = 'right';
    const PLACEMENT_DOWN  = 'down';
    const PLACEMENT_LEFT  = 'left';

    const MODE_INLINE = 'inline';
    const MODE_POPUP  = 'popup';

    /**
     * @param $name
     * @param Router $router
     * @param $routeName
     * @param array $options
     * @param array $source
     */
    function __construct($name, Router $router, $routeName, array $options = [], array $source = []) {
        $type         = isset($options['type']) ? $options['type'] : self::TYPE_TEXT;
        $mode         = isset($options['mode']) ? $options['mode'] : self::MODE_POPUP;
        $placement    = isset($options['placement']) ? $options['placement'] : self::PLACEMENT_RIGHT;
        $title        = isset($options['title']) ? $options['title'] : '';
        $pk           = isset($options['indexPath']) ? $options['indexPath'] : 'id';
        $property     = isset($options['property']) ? $options['property'] : $name;

        $options['decorators'] = [[
            [new EditableColumnDecorator(
                'a',
                $router,
                $routeName,
                $pk,
                [
                    'class'          => ['editable editable-click editable-column'],
                    'data-type'      => $type,
                    'data-placement' => $placement,
                    'data-title'     => $title,
                    'data-pk'        => $pk,
                    'data-name'      => $property,
                    'data-source'    => str_replace('"', "&quot;", json_encode($source)),
                    'data-mode'      => $mode,
                    'href'           => '#'
            ]), self::PREPEND],
            [new ValueDecorator(), self::APPEND]
        ]];
        parent::__construct($name, $options);
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'apihour_frontend_editable_column';
    }
}