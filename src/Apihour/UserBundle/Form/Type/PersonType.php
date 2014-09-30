<?php

namespace Apihour\UserBundle\Form\Type;

use Apihour\FileBundle\Entity\File;
use Apihour\FileBundle\Form\Type\FileType;
use Apihour\UtilBundle\Form\Type\DateType;
use Apihour\UtilBundle\Form\Type\PhoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\UserBundle\Entity\Person;

/**
 * Class PersonType
 * @package Apihour\UserBundle\Form\Type
 */
class PersonType extends AbstractFormType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'firstname',
            'text',
            [
                'label'    => 'firstname',
                'required' => false,
                'attr'     => ['placeholder' => 'firstname']
            ]
        );

        $builder->add(
            'middlename',
            'text',
            [
                'label'    => 'middlename',
                'required' => false,
                'attr'     => ['placeholder' => 'middlename']
            ]
        );

        $builder->add(
            'lastname',
            'text',
            [
                'label'    => 'lastname',
                'required' => false,
                'attr'     => ['placeholder' => 'lastname']
            ]
        );

        $builder->add(
            'www',
            'url',
            [
                'label'    => 'www',
                'required' => false,
                'attr'     => ['placeholder' => 'www']
            ]
        );

        $builder->add(
            'birthday',
            'date',
            [
                'years'    => range(1900, date('Y')),
                'label'    => 'birthday',
                'required' => false,
            ]
        );

        $builder->add(
            'birthdayPlace',
            'text',
            [
                'label'    => 'birthdayPlace',
                'required' => false
            ]
        );

        $builder->add(
            'phones',
            'collection',
            [
                'type'         => new PhoneType(),
                'allow_add'    => true,
                'allow_delete' => true
            ]
        );

        $builder->add(
            'emails',
            'collection',
            [
                'type'         => 'email',
                'allow_delete' => true,
                'allow_add'    => true
            ]
        );

        $builder->add(
            'homeAddress',
            new AddressType(),
            [
                'label'    => 'home_address',
                'required' => false,
            ]
        );

        $builder->add(
            'correspondenceAddress',
            new AddressType(),
            [
                'label'    => 'correspondence_address',
                'required' => false,
            ]
        );

        $builder->add(
            'sameAddress',
            'checkbox',
            [
                'label'    => 'same_address',
                'required' => false
            ]
        );

        $builder->add(
            'avatar',
            new FileType(),
            [
                'cascade_validation' => true
            ]
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class'         => Person::class,
            'cascade_validation' => true,
        ]);
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'person';
    }
}