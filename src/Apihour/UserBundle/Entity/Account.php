<?php

namespace Apihour\UserBundle\Entity;

use Apihour\SettingsBundle\Entity\EntityHasOptionsInterface;
use Apihour\UserBundle\Entity\Account\AccountHasOption;
use Apihour\UserBundle\Entity\Account\AccountHasPrivilege;
use Apihour\UserBundle\Entity\Account\AccountType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class Account
 * @package Apihour\UserBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\UserBundle\Repository\AccountRepository")
 * @ORM\Table(name="accounts")
 */
class Account extends AbstractEntity implements EntityHasOptionsInterface {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * Typ konta. Może być darmowe, premium, itp...
     *
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Account\AccountType")
     * @ORM\JoinColumn(name="type", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var int
     */
    protected $type = AccountType::TYPE_FREE;

    /**
     * Uprawnienia(kontrolki) do danego konta.
     *
     * @ORM\OneToMany(targetEntity="Apihour\UserBundle\Entity\Account\AccountHasPrivilege", mappedBy="account")
     *
     * @var AccountHasPrivilege[]
     */
    protected $privileges;

    /**
     * @ORM\OneToMany(targetEntity="Apihour\UserBundle\Entity\Account\AccountHasOption", fetch="EAGER", mappedBy="account", cascade={"all"})
     *
     * @var AccountHasOption[]
     */
    protected $options;

    public function __construct() {
        parent::__construct();
        $this->privileges = new ArrayCollection();
        $this->options    = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return AccountHasPrivilege[]
     */
    public function getPrivileges() {
        return $this->privileges;
    }

    /**
     * @param AccountHasPrivilege[] $privileges
     */
    public function setPrivileges($privileges = []) {
        foreach ($privileges as $privilege) {
            $this->addPrivilege($privilege);
        }
    }

    /**
     * @param AccountHasPrivilege $privilege
     */
    public function addPrivilege(AccountHasPrivilege $privilege) {
        $this->privileges[] = $privilege;
    }

    /**
     * @return AccountHasOption[]
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection $options) {
        $this->options = $options;
    }
} 