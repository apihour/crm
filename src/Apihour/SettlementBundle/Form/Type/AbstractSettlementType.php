<?php

namespace Apihour\SettlementBundle\Form\Type;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Apihour\SettlementBundle\Entity\Settlement\Bill;
use Apihour\SettlementBundle\Repository\SettlementRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;
use DateTime;

/**
 * Class AbstractSettlementType
 * @package Apihour\SettlementBundle\Form\Type
 */
abstract class AbstractSettlementType extends AbstractFormType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            $builder->create(
                'receiptNumber',
                'text',
                [
                    'required' => true,
                ]
            )->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /** @var SettlementRepository $repository */
                $repository = $this->getRepository(AbstractSettlement::class);

            })
        );

        $builder->add(
            'issueAt',
            'date',
            [
                'required' => false,
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy',
                'attr'     => [
                    'placeholder' => 'settlement:issueAt',
                    'class'       => 'date-picker',
                ]
            ]
        );

        $builder->add(
            'sellAt',
            'date',
            [
                'required' => false,
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy',
                'attr'     => [
                    'placeholder' => 'settlement:sellAt',
                    'class'       => 'date-picker'
                ]
            ]
        );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var AbstractSettlement $data */
            $data = $event->getData();

            if ($data->getIssueAt() === null) {
                $data->setIssueAt(new DateTime());
            }
            if ($data->getSellAt() === null) {
                $data->setSellAt(new DateTime());
            }
        });
    }

    abstract public function getDataClass();

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => $this->getDataClass(),
            'validation_groups' => function (Form $form) {
                /** @var AbstractSettlement $settlement */
                $settlement = $form->getData();
                if ($settlement instanceof Bill) {
                    return null;
                } else {
                    return ['invoices'];
                }
            }
        ]);
    }
}