<?php

namespace Tutto\DataGridBundle\Twig;

use \Twig_Extension;
use \Twig_SimpleFunction;

/**
 * Class DataGridExtension
 * @package Tutto\DataGridBundle\Twig
 */
class DataGridExtension extends Twig_Extension {

    /**
     * @return array
     */
    public function getFunctions() {
        return array(
            new Twig_SimpleFunction('datagrid', function() {
                return $this;
            })
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'datagrid_extension';
    }
}