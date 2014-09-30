<?php

namespace Tutto\SecurityBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Tutto\SecurityBundle\Util\SuspendedInterface;

/**
 * Class User
 * @package Tutto\SecurityBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class User extends BaseUser implements SuspendedInterface {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tutto\SecurityBundle\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     *
     * @var Role
     */
    protected $role;

    /**
     * @var bool
     */
    protected $isSuspend = false;

    /**
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role) {
        $this->role = $role;
    }

    /**
     * @param array $roles
     * @return $this|void
     * @throws LogicException
     */
    public function setRoles(array $roles) {
        if(!empty($roles) && isset($roles[0])) {
            $this->setRole($roles[0]);
        } else {
            throw new LogicException("Roles is empty.");
        }
    }

    /**
     * @param Role $role
     * @return void
     */
    public function addRole($role) {
        $this->setRole($role);
    }

    /**
     * @return Role
     */
    public function getRoles() {
        return [
            $this->getRole()->getName()
        ];
    }

    /**
     * Suspend object.
     *
     * @return void
     */
    public function suspend() {
        $this->isSuspend = true;
    }

    /**
     * Activate object.
     *
     * @return void
     */
    public function activate() {
        $this->isSuspend = false;
    }

    /**
     * Check if object is suspended or activated.
     *
     * @return boolean
     */
    public function isSuspend() {
        return $this->isSuspend;
    }
}