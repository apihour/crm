<?php

namespace Tutto\CommonBundle\Configuration;

/**
 * Class AbstractConfiguration
 * @package Tutto\CommonBundle\Configuration
 */
abstract class AbstractConfiguration {
    /**
     * @param array $options
     */
    public function __construct(array $options = array()) {
        foreach ($options as $key => $option) {
            $this->{$key} = $option;
        }
    }
} 