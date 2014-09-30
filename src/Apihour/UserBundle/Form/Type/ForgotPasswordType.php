<?php

namespace Apihour\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class ForgotPasswordType
 * @package Apihour\UserBundle\Form\Type
 */
class ForgotPasswordType extends AbstractFormType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'email',
            'email',
            [
                'attr' => [
                    'placeholder' => 'messages:email'
                ]
            ]
        );
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'forgot_password';
    }
}