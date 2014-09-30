<?php

namespace Apihour\UserBundle\Form\Type;

use Apihour\UserBundle\Entity\Role;
use Apihour\UserBundle\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tutto\CommonBundle\Form\AbstractFormType;
use Tutto\SecurityBundle\Repository\RoleRepository;

/**
 * Class RoleType
 * @package Apihour\UserBundle\Form\Type
 */
class RoleType extends AbstractFormType {
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'class'      => Role::class,
            'property'   => 'name',
            'label'      => 'role.role_name',
            'choices'    => $this->getChoices(),
            'required'   => true,
            'cascade_validation' => true,
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
        return 'apihour_user_role';
    }

    /**
     * @return array
     */
    protected function getChoices() {
        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(Role::class);
        $roles = [];

        /** @var User $user */
        if (($user = $this->getUser()) !== null && $user->getCurrentUserAccount() !== null) {
            $role = $user->getCurrentUserAccount()->getRole()->getName();
        }

        return $roles;
    }
}