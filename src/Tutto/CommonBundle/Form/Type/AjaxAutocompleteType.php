<?php

namespace Tutto\CommonBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class AjaxAutocomplete
 * @package Tutto\CommonBundle\Form\Type
 */
class AjaxAutocompleteType extends AbstractFormType {
    private $source;
    private $idFieldName   = 'id';
    private $termFieldName = 'name';

    /**
     * @param $source
     * @param array $options
     */
    public function __construct($source, array $options = array()) {
        $this->source = $source;
        foreach ($options as $key => $val) {
            if(is_string($key)) {
                $this->{$key} = $val;
            }
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $target = md5(time().rand(0,100));

        $builder->add(
            $this->idFieldName,
            'hidden',
            [
                'required' => false,
                'attr'     => ['class' => $target.' idAutocomplete']
            ]
        );

        $builder->add(
            $this->termFieldName,
            'text',
            [
                'label'    => 'autocomplete.term',
                'required' => false,
                'attr' => [
                    'class'  => "autocomplete",
                    'data-url' => $this->source,
                    'data-target' => $target,
                    'placeholder' => 'autocomplete.term',
                ]
            ]
        );
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'ajax_autocomplete';
    }
}