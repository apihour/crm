<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Tutto\CommonBundle\Util\Status;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\StatusDecorator;

/**
 * Class StatusColumn
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 */
class StatusColumn extends AbstractColumn {
    /**
     * @param Translator $translator
     * @param string $name
     * @param array $statusOptions
     * @param array $options
     */
    function __construct(Translator $translator, $name = 'status', array $statusOptions = array(), array $options = []) {
        $statusOptions = array_merge_recursive(
            [
                [
                    'status' => Status::DISABLED,
                    'class'  => 'label label-sm label-danger',
                    'label'  => 'status.disabled'
                ],
                [
                    'status' => Status::ENABLED,
                    'class'  => 'label label-sm label-success',
                    'label'  => 'status.enabled'
                ],
                [
                    'status' => Status::ARCHIVED,
                    'class'  => 'label label-sm label-warning',
                    'label'  => 'status.archived'
                ],
            ],
            $statusOptions
        );

        $options['decorators'] = [[[new StatusDecorator($translator, $statusOptions), self::PREPEND]]];
        parent::__construct($name, $options);
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'status_column';
    }
}