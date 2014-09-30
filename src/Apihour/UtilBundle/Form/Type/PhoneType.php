<?php

namespace Apihour\UtilBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class PhoneType
 * @package Apihour\UtilBundle\Form\Type
 */
class PhoneType extends AbstractFormType {
    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent() {
        return 'text';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => null,
            'attr' => [
                'class' => 'input-mask-phone'
            ]
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_util_phone';
    }
}