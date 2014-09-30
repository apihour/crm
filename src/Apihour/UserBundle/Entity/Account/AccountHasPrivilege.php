<?php

namespace Apihour\UserBundle\Entity\Account;

use Doctrine\ORM\Mapping as ORM;

use Tutto\CommonBundle\Entity\AbstractEntity;
use Apihour\UserBundle\Entity\Account;

use \InvalidArgumentException;

/**
 * Class AccountHasPrivilege
 * @package Apihour\UserBundle\Entity\Account
 *
 * @ORM\Entity(repositoryClass="Apihour\UserBundle\Repository\Account\AccountHasPrivilegeRepository")
 * @ORM\Table(name="accounts_has_privileges")
 */
class AccountHasPrivilege extends AbstractEntity {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Account", inversedBy="privileges")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     *
     * @var Account
     */
    protected $account;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Account\AccountPrivilege")
     * @ORM\JoinColumn(name="privilege_id", referencedColumnName="id")
     *
     * @var AccountPrivilege
     */
    protected $privilege;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $value;

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
    public function setAccount($account) {
        $this->account = $account;
    }

    /**
     * @return AccountPrivilege
     */
    public function getPrivilege() {
        return $this->privilege;
    }

    /**
     * @param AccountPrivilege $privilege
     */
    public function setPrivilege($privilege) {
        $this->privilege = $privilege;
    }

    /**
     * @return string
     */
    public function getPrivilegeName() {
        return $this->getPrivilege()->getName();
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getIntValue() {
        if (preg_match('/^(-){0,1}\d+$/i', $this->value)) {
            return (int) $this->value;
        } else {
            throw new InvalidArgumentException("'{$this->value}' is not number.");
        }
    }

    /**
     * @return float
     */
    public function getFloatValue() {
        if (preg_match('/^(-){0,1}\d+$/i', $this->value)) {
            return (float) $this->value;
        } else {
            throw new InvalidArgumentException("'{$this->value}' is not number.");
        }
    }

    /**
     * @return boolean
     */
    public function getBooleanValue() {
        if (preg_match('/^(0|1){1}$/i', $this->value)) {
            return (boolean) $this->value;
        } else {
            throw new InvalidArgumentException("'{$this->value}' is not boolean.");
        }
    }

    /**
     * @param string $value
     */
    public function setValue($value) {
        $this->value = $value;
    }
} 