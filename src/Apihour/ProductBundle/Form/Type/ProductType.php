<?php

namespace Apihour\ProductBundle\Form\Type;

use Apihour\FrontendBundle\Form\Type\CategorySelectable;
use Apihour\FrontendBundle\Form\Type\CategoryType;
use Apihour\ProductBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormView;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Entity\Currency;
use Tutto\CommonBundle\Form\AbstractFormType;
use Tutto\CommonBundle\Form\Type\CurrencyType;
use Tutto\CommonBundle\Form\Type\StatusType;
use Tutto\CommonBundle\Util\Status;

/**
 * Class ProductType
 * @package Apihour\ProductBundle\Form\Type
 */
class ProductType extends AbstractFormType {
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
                'label'    => 'product:name',
                'required' => true,
                'attr'     => ['placeholder' => 'product:name']
            ]
        );

        $builder->add(
            'shortName',
            'text',
            [
                'label'    => 'product:short_name',
                'required' => false,
                'attr'     => ['placeholder' => 'product:short_name']
            ]
        );

        $builder->add(
            'type',
            'choice',
            [
                'label'    => 'product:type.name',
                'required' => true,
                'choices'  => [
                    Product::TYPE_SELL => 'product:type.sell',
                    Product::TYPE_BUY  => 'product:type.buy'
                ]
            ]
        );

        $builder->add(
            'price',
            'text',
            [
                'label'    => 'product:price',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'product:price'
                ]
            ]
        );

        $builder->add(
            'priceWithVat',
            'text',
            [
                'label'    => 'product:vat_price',
                'required' => false,
                'mapped'   => false,
                'attr'     => [
                    'placeholder' => 'product:vat_price'
                ]
            ]
        );

        $builder->add(
            'vat',
            'text',
            [
                'label' => 'product:vat',
                'required' => false,
                'attr'     => ['placeholder' => 'product:vat']
            ]
        );

        $builder->add(
            'currency',
            new CurrencyType($this->getContainer()),
            [
                'label' => 'product:currency'
            ]
        );

        $builder->add(
            'status',
            new StatusType()
        );

        $builder->add(
            'category',
            new CategorySelectable($this->getContainer())
        );

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form  = $event->getForm();
            $vat   = $form->get('vat')->getData();
            $price = (float) $form->get('price')->getData();

            if (is_numeric($vat)) {
                $value = $price * $vat;
            } else {
                $value = 0.0;
            }

            $form->get('priceWithVat')->setData($value);
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_product_product';
    }
}