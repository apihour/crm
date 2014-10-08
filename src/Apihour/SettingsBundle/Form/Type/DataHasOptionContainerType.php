<?php

namespace Apihour\SettingsBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\SettingsBundle\Entity\AbstractDataHasOption;
use Apihour\SettingsBundle\Entity\EntityHasOptionsInterface;

/**
 * Class DataHasOptionContainerType
 * @package Apihour\SettingsBundle\Form\Type
 */
class DataHasOptionContainerType extends AbstractFormType {
    /**
     * @var EntityHasOptionsInterface
     */
    protected $entity;

    /**
     * @var string
     */
    protected $typeName;

    /**
     * @param EntityHasOptionsInterface $entity
     * @param $typeName
     * @param ContainerInterface $container
     */
    public function __construct(EntityHasOptionsInterface $entity, $typeName, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->entity   = $entity;
        $this->typeName = $typeName;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        /** @var AbstractDataHasOption $option */
        foreach ($this->entity->getOptions() as $option) {
            $group = $option->getOption()->getGroup();
            $name  = $option->getOption()->getName();

            $builder->add(
                $builder->create(
                    "{$group}_{$name}",
                    new DataHasOptionType($option),
                    [
                        'data_class' => get_class($option)
                    ]
                )->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($option) {
                    $event->setData($option);
                })
            );
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => null,
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