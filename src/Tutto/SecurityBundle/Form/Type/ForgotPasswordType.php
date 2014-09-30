<?php

namespace Tutto\SecurityBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class ResetPasswordType
 * @package Tutto\SecurityBundle\Form\Type
 */
class ForgotPasswordType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'email',
            'email',
            [
                'attr'        => ['placeholder' => 'email'],
                'constraints' => [
                    new Email()
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