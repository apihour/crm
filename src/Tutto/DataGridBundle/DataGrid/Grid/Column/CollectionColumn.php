<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\CollectionDecorator;

/**
 * Class CollectionColumn
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 */
class CollectionColumn extends AbstractColumn {
    /**
     * @param string $name
     * @param array $propertyPath
     * @param array $options
     */
    function __construct($name, $propertyPath, array $options = []) {
        $options = array_merge_recursive(
            $options,
            ['decorators' => [[[new CollectionDecorator($propertyPath), self::PREPEND]]]]
        );

        parent::__construct($name, $options);
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'column_collection';
    }
}