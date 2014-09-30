<?php

namespace Tutto\CommonBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Entity\Currency;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class CurrencyType
 * @package Tutto\CommonBundle\Form\Type
 */
class CurrencyType extends AbstractFormType {
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'class'    => Currency::class,
            'choices'  => $this->getEm()->getRepository(Currency::class)->findAll(),
            'property' => 'currency'
        ]);
    }

    /**
     * @return string
     */
    public function getParent() {
        return 'entity';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_common_currency';
    }
}