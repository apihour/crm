<?php

namespace Tutto\SecurityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class RegistrationType
 * @package Tutto\SecurityBundle\Form\Type
 */
class RegistrationType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'email',
            'email',
            array(
                'label' => 'email',
                'attr'  => ['placeholder' => 'email']
            )
        );

        $builder->add(
            'plainPassword',
            'repeated',
            array(
                'invalid_message' => 'password.not_valid',
                'type' => 'password',
                'first_options' => array(
                    'label' => 'password.first',
                    'attr'  => ['placeholder' => 'password.first']
                ),
                'second_options' => array(
                    'label' => 'password.second',
                    'attr'  => ['placeholder' => 'password.second']
                )
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'registration';
    }
}