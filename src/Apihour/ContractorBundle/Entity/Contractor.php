<?php

namespace Apihour\ContractorBundle\Entity;

use Apihour\ContractorBundle\Entity\Contractor\ContractorHasAccount;
use Apihour\ContractorBundle\Entity\Contractor\ContractorType;
use Apihour\UserBundle\Entity\Person;
use Apihour\UserBundle\Entity\User\UserAccount;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class Contractor
 * @package Apihour\ContractorBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\ContractorBundle\Repository\ContractorRepository")
 * @ORM\Table(name="contractors")
 */
class Contractor extends AbstractEntity {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Apihour\ContractorBundle\Entity\Contractor\ContractorHasAccount", mappedBy="contractor")
     *
     * @var ContractorHasAccount[]
     */
    protected $accounts;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $type = ContractorType::TYPE_PERSON;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     *
     * @var string
     */
    protected $shortName = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $iban = null;

    /**
     * @ORM\OneToOne(targetEntity="Apihour\UserBundle\Entity\Person", cascade={"persist"})
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Person
     */
    protected $person = null;

    /**
     * @ORM\OneToOne(targetEntity="Apihour\UserBundle\Entity\User\UserAccount", cascade={"persist"})
     * @ORM\JoinColumn(name="user_account_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var UserAccount
     */
    protected $ownerUserAccount;

    function __construct()
    {
        parent::__construct();
        $this->accounts = new ArrayCollection();
    }

    /**
     * @param \Apihour\ContractorBundle\Entity\Contractor\ContractorHasAccount[] $accounts
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * @return \Apihour\ContractorBundle\Entity\Contractor\ContractorHasAccount[]
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Apihour\UserBundle\Entity\Person $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @return \Apihour\UserBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $shortName
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param UserAccount $ownerUserAccount
     */
    public function setOwnerUserAccount($ownerUserAccount)
    {
        $this->ownerUserAccount = $ownerUserAccount;
    }

    /**
     * @return UserAccount
     */
    public function getOwnerUserAccount()
    {
        return $this->ownerUserAccount;
    }

    /**
     * @param string $iban
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getPerson()->getFirstname() . ' ' . $this->shortName;
    }
}