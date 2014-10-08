<?php

namespace Apihour\SettingsBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\SettingsBundle\Entity\AbstractDataHasOption;

/**
 * Class DataHasOptionType
 * @package Apihour\SettingsBundle\Form\Type
 */
class DataHasOptionType extends AbstractFormType {
    /**
     * @var AbstractDataHasOption
     */
    protected $option;

    /**
     * @param AbstractDataHasOption $option
     * @param ContainerInterface $container
     */
    public function __construct(AbstractDataHasOption $option, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->option   = $option;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            $builder->create(
                'name',
                'hidden',
                [
                    'required'      => true,
                    'read_only'     => true,
                    'property_path' => 'option.name'
                ]
            )->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $event->setData($this->option->getOption()->getName());
            })
        );

        $builder->add(
            $builder->create(
                'group',
                'hidden',
                [
                    'required'      => true,
                    'read_only'     => true,
                    'property_path' => 'option.group'
                ]
            )->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $event->setData($this->option->getOption()->getGroup());
            })
        );

        $opt  = $this->option->getOption()->getConstraints();
        $type = $this->option->getOption()->getType();
        if ($type !== 'choice') {
            unset($opt['choices']);
        }

        $builder->add(
            'value',
            $type,
            $opt
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => get_class($this->option)
        ]);
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_data_has_option_'.$this->option->getOption()->getName();
    }
}