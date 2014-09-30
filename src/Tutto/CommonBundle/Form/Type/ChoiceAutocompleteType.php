<?php

namespace Tutto\CommonBundle\Form\Type;
;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class ChoiceAutocompleteType
 * @package Tutto\CommonBundle\Form\Type
 */
class ChoiceAutocompleteType extends AbstractFormType {
    protected $choices        = array();
    protected $termLabel      = 'term';
    protected $valueFieldName = "value";
    protected $termFieldName  = "term";

    public function __construct(array $options = array()) {
        foreach ($options as $key => $option) {
            $this->{$key} = $option;
        }
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $target = md5(time().rand(0,100));

        $builder->add(
            $this->termFieldName,
            'text',
            [
                'required' => false,
                'label'    => $this->termLabel,
                'attr' => [
                    'class'  => 'term',
                    'target' => $target
                ]
            ]
        );

        $builder->add(
            $this->valueFieldName,
            'hidden',
            [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'class' => 'value ' . $target
                ]
            ]
        );

        $builder->add(
            'choice',
            'choice',
            [
                'choices'   => $this->choices,
                'mapped'    => false,
                'read_only' => true,
                'label'     => false,
                'attr'      => [
                    'class' => 'hidden choices ' . $target
                ]
            ]
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'attr' => ['class' => 'choice-autocomplete']
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'choice_autocomplete';
    }
}