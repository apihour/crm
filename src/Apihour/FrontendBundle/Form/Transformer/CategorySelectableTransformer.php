<?php

namespace Apihour\FrontendBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Apihour\FrontendBundle\Entity\Category;

/**
 * Class CategorySelectableTransformer
 * @package Apihour\FrontendBundle\Form\Transformer
 */
class CategorySelectableTransformer implements DataTransformerInterface {
    /**
     * @param mixed $value
     * @return mixed
     */
    public function transform($value) {
        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value) {
        if (isset($value['create']) && $value['create'] instanceof Category) {
            return $value['create'];
        } elseif (isset($value['selected']) && $value['selected'] instanceof Category) {
            return $value['selected'];
        } else {
            return null;
        }
    }
}