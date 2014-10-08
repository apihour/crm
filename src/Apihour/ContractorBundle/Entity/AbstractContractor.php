<?php

namespace Apihour\ContractorBundle\Entity;

use Apihour\ContractorBundle\Entity\Contractor\ContractorHasAccount;
use Apihour\ContractorBundle\Entity\Contractor\ContractorHasOption;
use Apihour\ContractorBundle\Entity\Contractor\ContractorType;
use Apihour\FrontendBundle\Entity\AbstractOwnerUserAccount;
use Apihour\FrontendBundle\Entity\Category;
use Apihour\SettingsBundle\Entity\AbstractDataHasOption;
use Apihour\SettingsBundle\Entity\EntityHasOptionsInterface;
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
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "buyer" = "Apihour\ContractorBundle\Entity\Buyer",
 *      "seller" = "Apihour\ContractorBundle\Entity\Seller"
 * })
 * @ORM\Table(name="contractors")
 */
abstract class AbstractContractor extends AbstractOwnerUserAccount implements EntityHasOptionsInterface {
    const PRIORITY_VERY_HIGH = 1;
    const PRIORITY_HIGH      = 2;
    const PRIORITY_NORMAL    = 3;
    const PRIORITY_LOW       = 4;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $type = ContractorType::TYPE_PERSON;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $taxNumber;

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
     * @ORM\Column(type="integer", nullable=false, options={"default": 3})
     *
     * @var int
     */
    protected $priority = self::PRIORITY_NORMAL;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $iban = null;

    /**
     * @ORM\OneToOne(targetEntity="Apihour\UserBundle\Entity\Person", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Person
     */
    protected $person = null;

    /**
     * Polska Klasyfikacja Działalności
     *
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string|null
     */
    protected $pkd = null;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User\UserAccount", fetch="EAGER")
     * @ORM\JoinColumn(name="customer_assistant_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var UserAccount
     */
    protected $customerAssistant = null;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\FrontendBundle\Entity\Category", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Category
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="Apihour\ContractorBundle\Entity\Contractor\ContractorHasAccount", mappedBy="contractor", cascade={"all"})
     *
     * @var ContractorHasAccount[]
     */
    protected $accounts;

    /**
     * @ORM\OneToMany(targetEntity="Apihour\ContractorBundle\Entity\Contractor\ContractorHasOption", mappedBy="contractor", cascade={"all"})
     *
     * @var ContractorHasOption[]
     */
    protected $options;

    function __construct() {
        parent::__construct();
        $this->accounts = new ArrayCollection();
        $this->options  = new ArrayCollection();
    }

    abstract public function getAliasName();

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTaxNumber() {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     */
    public function setTaxNumber($taxNumber) {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return string
     */
    public function getShortName() {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName($shortName) {
        $this->shortName = $shortName;
    }

    /**
     * @return int
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority) {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getIban() {
        return $this->iban;
    }

    /**
     * @param string $iban
     */
    public function setIban($iban) {
        $this->iban = $iban;
    }

    /**
     * @return Person
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson($person) {
        $this->person = $person;
    }

    /**
     * @return null|string
     */
    public function getPkd() {
        return $this->pkd;
    }

    /**
     * @param null|string $pkd
     */
    public function setPkd($pkd) {
        $this->pkd = $pkd;
    }

    /**
     * @return UserAccount
     */
    public function getCustomerAssistant() {
        return $this->customerAssistant;
    }

    /**
     * @param UserAccount $customerAssistant
     */
    public function setCustomerAssistant($customerAssistant) {
        $this->customerAssistant = $customerAssistant;
    }

    /**
     * @return Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category) {
        $this->category = $category;
    }

    /**
     * @return Contractor\ContractorHasAccount[]
     */
    public function getAccounts() {
        return $this->accounts;
    }

    /**
     * @param Contractor\ContractorHasAccount[] $accounts
     */
    public function setAccounts($accounts) {
        $this->accounts = $accounts;
    }



    /**
     * @return ContractorHasOption
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