<?php

namespace Apihour\SettingsBundle\Form\Type;

use Apihour\SettingsBundle\Form\EventSubscribers\ChoicesConstraints;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class AbstractOptionConstraintsType
 * @package Apihour\SettingsBundle\Form\Type
 */
class OptionConstraintsType extends AbstractFormType {
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @param ContainerInterface $container
     */
    public function __construct($name, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->name = $name;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'required',
            'choice',
            [
                'required' => true,
                'choices'  => [
                    true  => 'true',
                    false => 'false'
                ]
            ]
        );

        $builder->addEventSubscriber(new ChoicesConstraints());
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return $this->name;
    }
}