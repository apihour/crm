<?php

namespace Apihour\ProductBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\FrontendBundle\Form\Type\CategorySelectable;
use Apihour\ProductBundle\Entity\ProductPackage;

/**
 * Class ProductPackageType
 * @package Apihour\ProductBundle\Form\Type
 */
class ProductPackageType extends AbstractFormType {
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'name',
            'text',
            [
                'label'    => 'package:name',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'package:name'
                ]
            ]
        );

        $builder->add(
            'shortName',
            'text',
            [
                'label'    => 'package:short_name',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'package:short_name'
                ]
            ]
        );

        $builder->add(
            'category',
            new CategorySelectable($this->getContainer())
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => ProductPackage::class
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_product_package';
    }
}