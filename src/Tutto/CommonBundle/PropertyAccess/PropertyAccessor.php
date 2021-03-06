<?php

namespace Tutto\CommonBundle\PropertyAccess;

use Symfony\Component\PropertyAccess\PropertyAccessor as BasePropertyAccessor;

/**
 * Class PropertyAccessor
 * @package Tutto\CommonBundle\PropertyAccess
 */
class PropertyAccessor extends BasePropertyAccessor {
    /**
     * @param array|object $objectOrArray
     * @param string|\Symfony\Component\PropertyAccess\PropertyPathInterface $propertyPath
     * @return mixed
     */
    public function getValue($objectOrArray, $propertyPath) {
        if (is_array($objectOrArray)) {
            $paths = explode('.', $propertyPath);
            $propertyPath = '';
            foreach ($paths as $path) {
                $propertyPath.= '['.trim($path, '[]').']';
            }
        }

        return parent::getValue($objectOrArray, $propertyPath);
    }
} 