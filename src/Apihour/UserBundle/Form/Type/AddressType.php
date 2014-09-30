<?php

namespace Apihour\UserBundle\Form\Type;

use Apihour\UserBundle\Entity\Address;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class AddressType
 * @package Apihour\UserBundle\Form\Type
 */
class AddressType extends AbstractFormType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('id', 'hidden');

        $builder->add(
            'country',
            'text',
            [
                'label' => 'country',
                'required' => false,
                'attr' => [
                    'placeholder' => 'country'
                ]
            ]
        );

        $builder->add(
            'city',
            'text',
            [
                'label' => 'city',
                'required' => false,
                'attr' => [
                    'placeholder' => 'city'
                ]
            ]
        );

        $builder->add(
            'voivodeship',
            'text',
            [
                'label' => 'voivodeship',
                'required' => false,
                'attr' => [
                    'placeholder' => 'voivodeship'
                ]
            ]
        );

        $builder->add(
            'postalCode',
            'text',
            [
                'label' => 'postalCode',
                'required' => false,
                'attr' => [
                    'placeholder' => 'postalCode'
                ]
            ]
        );

        $builder->add(
            'street',
            'text',
            [
                'label' => 'street',
                'required' => false,
                'attr' => [
                    'placeholder' => 'street'
                ]
            ]
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(['data_class' => Address::class]);
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'address';
    }
}