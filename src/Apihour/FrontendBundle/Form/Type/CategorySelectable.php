<?php

namespace Apihour\FrontendBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\FrontendBundle\Entity\Category;
use Apihour\FrontendBundle\Form\Transformer\CategorySelectableTransformer;
use Apihour\FrontendBundle\Repository\CategoryRepository;

/**
 * Class CategorySelectable
 * @package Apihour\FrontendBundle\Form\Type
 */
class CategorySelectable extends AbstractFormType {
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
            'create',
            new CategoryType($this->getContainer()),
            [
                'label'    => 'category.create',
                'required' => false
            ]
        );

        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = $this->getRepository(Category::class);
        $categories         = $categoryRepository->getCategoriesForCurrentUser();

        $builder->add(
            'selected',
            'entity',
            [
                'label'       => 'category.select',
                'read_only'   => empty($categories),
                'required'    => false,
                'empty_value' => empty($categories) ? 'category.empty' : 'category.select',
                'class'       => Category::class,
                'property'    => 'name',
                'choices'     => $categories
            ]
        );

        $builder->addModelTransformer(new CategorySelectableTransformer($this->getRepository(Category::class)));
    }


    /**
     * @return string
     */
    public function getName() {
        return 'apihour_category_category_selectable';
    }
} 