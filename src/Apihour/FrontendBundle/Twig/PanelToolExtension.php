<?php

namespace Apihour\FrontendBundle\Twig;

use Tutto\CommonBundle\Services\Translator;
use Tutto\XhtmlBundle\Lib\SimpleText;
use Tutto\XhtmlBundle\Lib\Tag;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class PanelToolExtension
 * @package Apihour\FrontendBundle\Twig
 */
class PanelToolExtension extends Twig_Extension {
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param Translator $translator
     */
    public function __construct(Translator $translator) {
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            new Twig_SimpleFunction('paneltool', [$this, 'paneltool'])
        ];
    }

    public function paneltool() {
        return $this;
    }

    /**
     * @param array $attr
     * @param array $items
     * @return Tag
     */
    public function dropdown(array $attr = ['attr' => [], 'items' => []], array $items = ['collapse', 'refresh', 'expand']) {
        return new Tag('div', ['class' => ['dropdown']],
            [
                new Tag('a', ['class' => ['btn btn-xs dropdown-toggle btn-transparent-grey'], 'data-toggle' => 'dropdown'], [
                    new Tag('i', ['class' => 'fa fa-cog'])
                ]),
                $this->menu($attr, $items)
            ]
        );
    }

    /**
     * @param array $attr
     * @param array $items
     * @return Tag
     */
    public function menu(array $attr = ['attr' => [], 'items' => []], array $items = ['collapse', 'refresh', 'expand']) {
        $attr = array_merge_recursive(
            [
                'attr' => [
                    'class' => ['dropdown-menu dropdown-light pull-right'],
                    'role'  => ['menu']
                ],
                'items' => []
            ],
            $attr
        );

        $ul = new Tag('ul', $attr['attr']);
        foreach ($items as $item) {
            if (is_callable([$this, $item])) {
                $values = isset($attr['items'][$item]) ? $attr['items'][$item] : [];

                $ul->addChild($this->{$item}($values));
            }
        }

        return $ul;
    }

    /**
     * @param array $attr
     * @return Tag
     */
    public function collapse(array $attr = []) {
        return $this->item(array_merge_recursive(
            [
                'attr' => [
                    'class' => ['panel-collapse collapses']
                ],
                'fa'    => 'fa fa-angle-up',
                'label' => 'panel.tool.collapse'
            ],
            $attr
        ));
    }

    /**
     * @param array $attr
     * @return Tag
     */
    public function refresh(array $attr = []) {
        return $this->item(array_merge_recursive(
            [
                'attr' => [
                    'class' => ['panel-refresh'],
                ],
                'fa'    => 'fa fa-refresh',
                'label' => 'panel.tool.refresh'
            ]
        ));
    }

    /**
     * @param array $attr
     * @return Tag
     */
    public function conf(array $attr = []) {
        return $this->item(array_merge_recursive(
            [
                'attr' => [
                    'class' => ['panel-conf'],
                ],
                'fa'   => 'fa fa-wrench',
                'label' => 'panel.tool.conf'
            ]
        ));
    }

    public function expand(array $attr = []) {
        return $this->item(array_merge_recursive(
            [
                'attr' => [
                    'class' => 'panel-expand'
                ],
                'fa'    => 'fa fa-expand',
                'label' => 'panel.tool.expand'
            ]
        ));
    }

    /**
     * @param array $attr
     * @return Tag
     */
    public function item(array $attr = []) {
        $attr = array_merge_recursive(
            [
                'attr' => [
                    'class' => [],
                    'href'  => '#'
                ],
                'fa' => '',
                'li' => ['attr' => []],
            ],
            $attr
        );
        $label = !empty($attr['label']) ? $this->translator->trans($attr['label']) : '';

        $i    = new Tag('i', ['class' => $attr['fa']]);
        $span = new Tag('span', [], [new SimpleText($label)]);
        $concat = new SimpleText('', [$i, $span]);

        $a    = new Tag('a', $attr['attr'], [$concat]);

        return new Tag('li', $attr['li'], [$a]);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'apihour_frontend_panel_tool';
    }
}