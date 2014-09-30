<?php

namespace Apihour\FrontendBundle\Form\Type;

use Apihour\FrontendBundle\Entity\Category;
use Apihour\FrontendBundle\Repository\CategoryRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class CategoryType
 * @package Apihour\FrontendBundle\Form\Type
 */
class CategoryType extends AbstractFormType {
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
                'label'    => 'category.name',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'category.name'
                ]
            ]
        );

        $builder->add(
            'description',
            'textarea',
            [
                'label'    => 'category.description',
                'required' => false,
            ]
        );

        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = $this->getRepository(Category::class);
        $categories         = $categoryRepository->getCategoriesForCurrentUser();

        $builder->add(
            'parent',
            'entity',
            [
                'label'       => 'category.parent',
                'read_only'   => empty($categories),
                'required'    => false,
                'empty_value' => empty($categories) ? 'category.empty' : 'category.select',
                'class'       => Category::class,
                'property'    => 'name',
                'choices'     => $categoryRepository->getCategoriesForCurrentUser(),
                'attr'        => [
                    'class' => 'search-select'
                ]
            ]
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'required'   => false
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_frontend_category';
    }
}