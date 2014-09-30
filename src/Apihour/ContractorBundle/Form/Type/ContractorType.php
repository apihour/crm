<?php

namespace Apihour\ContractorBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\ContractorBundle\Entity\Contractor;
use Apihour\ContractorBundle\Form\Type\Person\PersonType;

/**
 * Class ContractorType
 * @package Apihour\ContractorBundle\Form\Type
 */
abstract class ContractorType extends AbstractFormType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add(
            'shortname',
            'text',
            [
                'label'    => 'contractor.form.shortname',
                'required' => false,
                'attr'     => ['placeholder' => 'contractor.form.shortname']
            ]
        );

        $builder->add(
            'iban',
            'text',
            [
                'label'    => 'contractor.form.iban',
                'required' => false,
                'attr'     => ['placeholder' => 'contractor.form.iban']
            ]
        );

        $builder->add(
            'person',
            new PersonType()
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(['data_class' => Contractor::class]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'contractor';
    }
} 