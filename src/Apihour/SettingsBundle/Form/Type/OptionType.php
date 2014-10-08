<?php

namespace Apihour\SettingsBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\SettingsBundle\Entity\AbstractDataOption;

/**
 * Class OptionType
 * @package Apihour\SettingsBundle\Form\Type
 */
class OptionType extends AbstractFormType {
    /**
     * @var string
     */
    protected $dataClass;

    /**
     * @var string
     */
    protected $constraintsTypeName;

    /**
     * @var string
     */
    protected $typeName;

    /**
     * @param string $typeName
     * @param string $dataClass
     * @param string $constraintsTypeName
     * @param ContainerInterface $container
     */
    public function __construct($typeName, $dataClass, $constraintsTypeName, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->dataClass = $dataClass;
        $this->constraintsTypeName = $constraintsTypeName;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'group',
            'text',
            [
                'required' => true,
                'attr'     => [
                    'placeholder' => 'account_options:group'
                ]
            ]
        );

        $builder->add(
            'name',
            'text',
            [
                'required' => true,
                'attr'     => [
                    'placeholder' => 'account_options:name'
                ]
            ]
        );

        $builder->add(
            'type',
            'choice',
            [
                'required' => true,
                'choices' => [
                    'text'     => 'account_options:text',
                    'textarea' => 'account_options:textarea',
                    'choice'   => 'choice'
                ]
            ]
        );

        $builder->add(
            'description',
            'textarea',
            [
                'required' => false,
                'attr'     => [
                    'placeholder' => 'account_options:description'
                ]
            ]
        );

        $builder->add(
            'shortDescription',
            'text',
            [
                'required' => false,
                'attr'     => [
                    'placeholder' => 'account_options:shortDescription'
                ]
            ]
        );

        $builder->add(
            'default',
            'text',
            [
                'required' => false,
                'attr'     => [
                    'placeholder' => 'account_options:default'
                ],
            ]
        );

        $builder->add('constraints', new OptionConstraintsType($this->constraintsTypeName));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => $this->dataClass,
            'validation_groups' => function (Form $form) {
                $data = $form->getData();
                if ($data instanceof AbstractDataOption) {
                    return $data->getType() === 'choice' ? 'choice' : null;
                }
            }
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return $this->typeName;
    }
}