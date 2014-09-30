<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Tutto\XhtmlBundle\Lib\SimpleText;
use Tutto\XhtmlBundle\Lib\Tag;
use Tutto\XhtmlBundle\Lib\TagInterface;

/**
 * Class StatusDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class StatusDecorator extends AbstractDecorator {
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param Translator $translator
     * @param array $options
     */
    public function __construct(Translator $translator, array $options) {
        $this->translator = $translator;
        $this->options    = $options;
    }

    /**
     * @return TagInterface
     */
    public function decorate() {
        if (is_numeric($this->getValue())) {
            $class = 'label label-sm label-inverse';
            $label = $this->translator->trans('status.flagged');
            foreach ($this->options as $status) {
                if ($status['status'] == $this->getValue()) {
                    $class = $status['class'];
                    $label = $this->translator->trans($status['label']);
                    break;
                }
            }

            return new Tag('span', ['class' => $class], [new SimpleText($label)]);
        }
    }
}