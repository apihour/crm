<?php

namespace Apihour\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class LoginType
 * @package Apihour\UserBundle\Form\Type
 */
class LoginType extends AbstractFormType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $csrfProvider = $this->getContainer()->get('form.csrf_provider');

        $builder->add(
            '_username',
            'text',
            [
                'attr' => array(
                    'placeholder' => 'login'
                ),
                'data' => $this->getSession()->get(SecurityContextInterface::LAST_USERNAME),
            ]
        );
        $builder->add('_password', 'password', array(
            'attr' => array(
                'placeholder' => 'password'
            )
        ));
        $builder->add(
            '_remember_me',
            'checkbox',
            array(
                'required' => false,
                'label'    => 'security:remember_me'
            )
        );
        $builder->add(
            '_csrf_token',
            'hidden',
            array(
                'data' => $csrfProvider->generateCsrfToken('authenticate')
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return '';
    }
}