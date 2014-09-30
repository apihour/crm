<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator\AbstractDecorator;
use Tutto\XhtmlBundle\Lib\SingleTag;
use Tutto\XhtmlBundle\Lib\Tag;
use Tutto\XhtmlBundle\Lib\TagInterface;

/**
 * Class CheckboxColumn
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column
 */
class CheckboxColumn extends AbstractColumn {
    /**
     * @param $name
     * @param array $options
     */
    function __construct($name = 'checkboxes', array $options = []) {
        if (!isset($options['propertyPath'])) {
            $options['propertyPath'] = 'id';
        }

        $options = array_merge_recursive(
            ['attributes' => ['class' => 'center']],
            $options
        );

        $options['decorators'] = [[
            [new CheckboxDecorator($name), self::PREPEND]
        ]];

        parent::__construct($name, $options);
    }

    /**
     * @return Tag
     */
    public function getLabel() {
        $input = new Tag('input', ['type' => 'checkbox', 'class' => 'flat-grey selectall']);
        $label = new Tag('label', [], [$input]);

        return new Tag('div', ['class' => 'checkbox-table'], [$label]);
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'column_checkbox';
    }
}

class CheckboxDecorator extends AbstractDecorator {
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    function __construct($name) {
        $this->name = $name;
    }

    /**
     * @return TagInterface
     */
    public function decorate() {
        return new Tag('div', ['class' => 'checkbox-table'], [new SingleTag(
            'input',
            [
                'type'  => 'checkbox',
                'value' => $this->getValue(),
                'name'  => $this->name,
                'class' => 'flat-grey'
            ]
        )]);
    }
}