<?php

namespace Apihour\UserBundle\Form\Type\Profile;

use Apihour\UserBundle\Entity\Role;
use Apihour\UserBundle\Form\Type\AddressType;
use Apihour\UserBundle\Form\Type\PersonType;
use Apihour\UserBundle\Form\Type\RoleType;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;
use Apihour\UserBundle\Entity\User\UserAccount;

/**
 * Class AbstractProfileType
 * @package Apihour\UserBundle\Form\Type\Profile
 */
abstract class AbstractProfileType extends AbstractFormType {
    /**
     * @var UserAccount
     */
    protected $userAccount;

    /**
     * @param UserAccount $userAccount
     * @param ContainerInterface $container
     */
    public function __construct(UserAccount $userAccount, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->userAccount = $userAccount;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'person',
            new PersonType(),
            [
                'cascade_validation' => true
            ]
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => UserAccount::class,
            'cascade_validation' => true
        ]);
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'user_profile';
    }
}