<?php
/**
 * Created by PhpStorm.
 * User: pkrawczyk
 * Date: 18.09.14
 * Time: 16:33
 */

namespace Apihour\ContractorBundle\Form\Type\Person;


use Apihour\FileBundle\Form\Type\FileType;
use Apihour\UserBundle\Form\Type\AddressType;
use Apihour\UtilBundle\Form\Type\PhoneType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class PersonType
 * @package Apihour\ContractorBundle\Form\Type\Person
 */
class PersonType extends \Apihour\UserBundle\Form\Type\PersonType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'taxNumber',
            'text',
            [
                'label'    => 'contractor.form.taxnumber',
                'required' => false,
                'attr'     => ['placeholder' => 'contractor.form.taxnumber']
            ]
        );

        $builder->add(
            'bankAccountNumber',
            'text',
            [
                'label'    => 'contractor.form.bankaccount',
                'required' => false,
                'attr'     => ['placeholder' => 'contractor.form.bankaccount']
            ]
        );
    }
} 