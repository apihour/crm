<?php

namespace Apihour\SettlementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Tutto\CommonBundle\Entity\Currency;
use Apihour\FrontendBundle\Entity\AbstractOwnerUserAccount;
use Apihour\FrontendBundle\Entity\Category;
use Apihour\SettlementBundle\Entity\Settlement\Contractor;
use Apihour\SettlementBundle\Exceptions\BadSettlementTypeException;
use DateTime;

/**
 * Class AbstractSettlement
 * @package Apihour\SettlementBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\SettlementBundle\Repository\SettlementRepository")
 * @ORM\Table(name="settlements")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "bill"="Apihour\SettlementBundle\Entity\Settlement\Bill",
 *      "invoice"="Apihour\SettlementBundle\Entity\Settlement\Invoice",
 *      "proforma_invoice"="Apihour\SettlementBundle\Entity\Settlement\ProformaInvoice",
 *      "prepayment_invoice"="Apihour\SettlementBundle\Entity\Settlement\PrepaymentInvoice",
 *      "final_invoice"="Apihour\SettlementBundle\Entity\Settlement\FinalInvoice",
 *      "corrective_invoice"="Apihour\SettlementBundle\Entity\Settlement\CorrectiveInvoice"
 * })
 */
abstract class AbstractSettlement extends AbstractOwnerUserAccount {
    const TYPE_INCOME  = 1;
    const TYPE_EXPENSE = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default": 1})
     *
     * @var int
     */
    private $type = self::TYPE_INCOME;

    /**
     * @ORM\Column(length=255, nullable=false)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $receiptNumber;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=4, nullable=true, options={"default": 0,0})
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $paid = 0.0;

    /**
     * @ORM\ManyToOne(targetEntity="Tutto\CommonBundle\Entity\Currency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
     *
     * @var Currency
     */
    private $currency;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    private $issuePlace;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"default": "2000-01-01 00:00:00"})
     * @Assert\NotBlank(groups={"invoices"})
     * @Assert\Date()
     *
     * @var DateTime
     */
    private $issueAt;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "2000-01-01 00:00:00"})
     *
     * @var DateTime
     */
    private $sellAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"default": "2000-01-01 00:00:00"})
     *
     * @var DateTime
     */
    private $deadlinePaymentAt;

    /**
     * @ORM\Column(length=255, nullable=false, options={"default": "cash"})
     *
     * @var string
     */
    private $paymentMethod;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\Contractor", cascade={"all"})
     * @ORM\JoinColumn(name="seller_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Contractor
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\Contractor", cascade={"all"})
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Contractor
     */
    private $buyer;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\FrontendBundle\Entity\Category", cascade={"all"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Category
     */
    private $category;

    /**
     *
     * @var ArrayCollection
     */
    protected $files;

    /**
     * @param int $type
     * @throws BadSettlementTypeException
     */
    public function __construct($type) {
        parent::__construct();
        $this->setType($type);
        $this->files = new ArrayCollection();
    }

    abstract function getPrice();

    abstract function getAliasName();

    /**
     * @return Contractor
     */
    public function getBuyer() {
        return $this->buyer;
    }

    /**
     * @param Contractor $buyer
     */
    public function setBuyer(Contractor $buyer) {
        $this->buyer = $buyer;
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
    public function setCategory(Category $category) {
        $this->category = $category;
    }

    /**
     * @return Currency
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency) {
        $this->currency = $currency;
    }

    /**
     * @return DateTime
     */
    public function getDeadlinePaymentAt() {
        return $this->deadlinePaymentAt;
    }

    /**
     * @param DateTime $deadlinePaymentAt
     */
    public function setDeadlinePaymentAt(DateTime $deadlinePaymentAt) {
        $this->deadlinePaymentAt = $deadlinePaymentAt;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getIssueAt() {
        return $this->issueAt;
    }

    /**
     * @param DateTime $issueAt
     */
    public function setIssueAt(DateTime $issueAt = null) {
        $this->issueAt = $issueAt;
    }

    /**
     * @return string
     */
    public function getIssuePlace() {
        return $this->issuePlace;
    }

    /**
     * @param string $issuePlace
     */
    public function setIssuePlace($issuePlace) {
        $this->issuePlace = $issuePlace;
    }

    /**
     * @return float
     */
    public function getPaid() {
        return $this->paid;
    }

    /**
     * @param float $paid
     */
    public function setPaid($paid) {
        $this->paid = (float) $paid;
    }

    /**
     * @return string
     */
    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return string
     */
    public function getReceiptNumber() {
        return $this->receiptNumber;
    }

    /**
     * @param string $receiptNumber
     */
    public function setReceiptNumber($receiptNumber) {
        $this->receiptNumber = $receiptNumber;
    }

    /**
     * @return DateTime
     */
    public function getSellAt() {
        return $this->sellAt;
    }

    /**
     * @param DateTime $sellAt
     */
    public function setSellAt(DateTime $sellAt) {
        $this->sellAt = $sellAt;
    }

    /**
     * @return Contractor
     */
    public function getSeller() {
        return $this->seller;
    }

    /**
     * @param Contractor $seller
     */
    public function setSeller(Contractor $seller) {
        $this->seller = $seller;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param int $type
     * @throws BadSettlementTypeException
     */
    public function setType($type) {
        if ($type === self::TYPE_INCOME || $type === self::TYPE_EXPENSE) {
            $this->type = $type;
        } else {
            throw new BadSettlementTypeException("Type: {$type} is not type income nor expense");
        }
    }
} 