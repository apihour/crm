<?php
/**
 * Created by PhpStorm.
 * User: pkrawczyk
 * Date: 10.09.14
 * Time: 12:55
 */

namespace Apihour\ContractorBundle\Entity\Contractor;

use Apihour\ContractorBundle\Entity\AbstractContractor;
use Apihour\ContractorBundle\Entity\Contractor;
use Apihour\UserBundle\Entity\User\UserAccount;
use Doctrine\ORM\Mapping as ORM;
use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class ContractorHasUser
 * @package Apihour\ContractorBundle\Entity\Contractor
 *
 * @ORM\Entity(repositoryClass="Apihour\ContractorBundle\Repository\Contractor\ContractorHasAccountRepository")
 * @ORM\Table(name="contractors_has_accounts")
 */
class ContractorHasAccount extends AbstractEntity {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\ContractorBundle\Entity\AbstractContractor", inversedBy="accounts")
     * @ORM\JoinColumn(name="contractor_id", referencedColumnName="id")
     *
     * @var AbstractContractor
     */
    protected $contractor;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User\UserAccount")
     * @ORM\JoinColumn(name="user_has_account_id", referencedColumnName="id")
     *
     * @var UserAccount
     */
    protected $userAccount;

    /**
     * @param \Apihour\ContractorBundle\Entity\Contractor $contractor
     */
    public function setContractor($contractor)
    {
        $this->contractor = $contractor;
    }

    /**
     * @return \Apihour\ContractorBundle\Entity\Contractor
     */
    public function getContractor()
    {
        return $this->contractor;
    }

    /**
     * @param \Apihour\ContractorBundle\Entity\Contractor\Account $userAccount
     */
    public function setUserAccount($userAccount)
    {
        $this->userAccount = $userAccount;
    }

    /**
     * @return \Apihour\ContractorBundle\Entity\Contractor\Account
     */
    public function getUserAccount()
    {
        return $this->userAccount;
    }
}