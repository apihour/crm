<?php

namespace Apihour\UserBundle\Form\Type\Profile;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class WorkerProfileType
 * @package Apihour\UserBundle\Form\Type\Profile
 */
class WorkerProfileType extends AbstractProfileType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);


    }
} 