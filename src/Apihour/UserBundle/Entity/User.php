<?php

namespace Apihour\UserBundle\Entity;

use Apihour\FileBundle\Entity\File;
use Apihour\UserBundle\Entity\User\UserAccount;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Model\User as BaseUser;

use JsonSerializable;
use Tutto\SecurityBundle\Util\SuspendedInterface;

/**
 * Class User
 * @package Apihour\UserBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser implements JsonSerializable, SuspendedInterface, SwitchableAccount {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $isSuspended = false;

    /**
     * @ORM\OneToMany(targetEntity="Apihour\UserBundle\Entity\User\UserAccount", mappedBy="user", cascade={"all"})
     *
     * @var UserAccount[]
     */
    protected $userAccounts;

    public function __construct() {
        parent::__construct();
        $this->setPerson(new Person());
        $this->accounts = new ArrayCollection();
    }

    /**
     * @return UserAccount[]
     */
    public function getUserAccounts() {
        return $this->userAccounts;
    }

    /**
     * @param UserAccount $userAccount
     */
    public function addUserAccount(UserAccount $userAccount) {
        $this->userAccounts[] = $userAccount;
    }

    /**
     * @return UserAccount|null
     */
    public function getCurrentUserAccount() {
        foreach ($this->getUserAccounts() as $userAccount) {
            if ($userAccount->isSelected()) {
                return $userAccount;
            }
        }

        return null;
    }

    /**
     * @param UserAccount $userAccount
     */
    public function switchUserAccount(UserAccount $userAccount) {
        $userAccount->select();
    }

    /**
     * @param Person $person
     * @return User
     */
    public function setPerson(Person $person = null) {
        $this->person = $person;

        return $this;
    }

    /**
     * @return null|Person
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;
        $this->setUsername($email);

        return $this;
    }

    /**
     * Suspend object.
     *
     * @return void
     */
    public function suspend() {
        $this->isSuspended = true;
    }

    /**
     * Activate object.
     *
     * @return void
     */
    public function activate() {
        $this->isSuspended = false;
    }

    /**
     * Check if object is suspended or activated.
     *
     * @return boolean
     */
    public function isSuspend() {
        return $this->isSuspended;
    }

    /**
     * @return File
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * @param File $avatar
     */
    public function setAvatar(File $avatar) {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id'         => $this->getId(),
            'email'      => $this->getEmail(),
            'last_login' => $this->getLastLogin(),
            'enabled'    => $this->isEnabled(),
            'locked'     => $this->isLocked(),
            'expired'    => $this->isExpired(),
            'person'     => $this->getPerson(),
        ];
    }
}