<?php

namespace Tutto\FileBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class FileType
 * @package Tutto\FileBundle\Form\Type
 */
abstract class FileType extends AbstractFormType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'title',
            'text',
            [
                'label'    => 'file.title',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'file.title'
                ]
            ]
        );

        $builder->add(
            'description',
            'textarea',
            [
                'label'    => 'file.description',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'file.description'
                ]
            ]
        );

        $builder->add(
            'file',
            'file',
            ['required' => false]
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'tutto_file_file';
    }
} 