<?php

namespace Apihour\UserBundle\Entity\Account;

use Apihour\SettingsBundle\Entity\AbstractDataHasOption;
use Apihour\SettingsBundle\Entity\AbstractDataOption;
use Apihour\UserBundle\Entity\Account;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class AccountSetting
 * @package Apihour\SettingsBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\UserBundle\Repository\Account\AccountHasOptionRepository")
 * @ORM\Table(name="accounts_has_options", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique_option", columns={"account_id", "option_id"})
 * })
 */
class AccountHasOption extends AbstractDataHasOption {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Account", inversedBy="options", cascade={"all"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Account
     */
    protected $account;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\Account\AccountOption", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="option_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var AccountOption
     */
    protected $option;

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
     * @return AccountOption
     */
    public function getOption() {
        return $this->option;
    }

    /**
     * @param AbstractDataOption $option
     */
    public function setOption(AbstractDataOption $option) {
        $this->option = $option;
    }
} 