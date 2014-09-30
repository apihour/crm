<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class TemplateDecorator
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Decorator
 */
class TemplateDecorator extends AbstractDecorator {
    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @var string
     */
    protected $template;

    /**
     * @param EngineInterface $engine
     * @param string $template
     */
    public function __construct(EngineInterface $engine, $template) {
        $this->engine   = $engine;
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function decorate() {
        return $this->engine->render($this->template, [
            'data'  => $this->getData(),
            'value' => $this->getValue()
        ]);
    }
}