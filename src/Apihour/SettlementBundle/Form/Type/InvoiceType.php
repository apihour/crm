<?php

namespace Apihour\SettlementBundle\Form\Type;
use Apihour\SettlementBundle\Entity\Settlement\Invoice;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class InvoiceType
 * @package Apihour\SettlementBundle\Form\Type
 */
class InvoiceType extends AbstractSettlementType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'apihour_settlement_invoice';
    }

    public function getDataClass() {
        return Invoice::class;
    }
}