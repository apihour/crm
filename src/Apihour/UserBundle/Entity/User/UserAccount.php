<?php

namespace Apihour\UserBundle\Entity\User;

use Apihour\UserBundle\Entity\Account;
use Apihour\UserBundle\Entity\Person;
use Doctrine\ORM\Mapping as ORM;
use Apihour\UserBundle\Entity\User;
use Tutto\SecurityBundle\Entity\Role;

/**
 * Class UserAccount
 * @package Apihour\UserBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="Apihour\UserBundle\Repository\UserAccountRepository")
 * @ORM\Table(
 *      name="users_has_accounts",
 *      indexes={
 *          @ORM\Index(
 *              name="unique_user_accounts",
 *              columns={"user_id", "account_id", "role_id"}
 *          )
 *      }
 * )
 */
class UserAccount {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $isSelected = false;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User", inversedBy="userAccounts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     *
     * @var Account
     */
    protected $account;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *
     * @var Role
     */
    protected $role;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Person", cascade={"persist"})
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
     *
     * @var Person
     */
    protected $person = null;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return Account
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account) {
        $this->account = $account;
    }

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
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user) {
        $this->user = $user;
    }

    /**
     * @return Person|null
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person) {
        $this->person = $person;
    }

    /**
     * @return bool
     */
    public function isSelected() {
        return $this->isSelected;
    }

    /**
     * @return void
     */
    public function select() {
        $this->isSelected = true;
    }

    /**
     * @return void
     */
    public function diselect() {
        $this->isSelected = false;
    }
} 