<?php

namespace Tutto\CommonBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class FormExtension
 * @package Tutto\CommonBundle\Twig
 */
class FormExtension extends Twig_Extension {
    /**
     * @return array
     */
    public function getFunctions() {
        return [
            new Twig_SimpleFunction('form', [$this, 'form'])
        ];
    }

    /**
     * @return $this
     */
    public function form() {
        return $this;
    }


    public function getName() {
        return 'tutto_common_form';
    }
}