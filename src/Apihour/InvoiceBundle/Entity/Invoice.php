<?php

namespace Apihour\InvoiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Apihour\FrontendBundle\Entity\AbstractOwnerUserAccount;
use DateTime;

/**
 * Class Invoice
 * @package Apihour\InvoiceBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\InvoiceBundle\Repository\InvoiceRepository")
 * @ORM\Table(name="invoices")
 */
class Invoice extends AbstractOwnerUserAccount {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(length=20, nullable=false)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $invoiceNumber;

    /**
     * @ORM\Column(type="date", nullable=false)
     *
     * @var DateTime
     */
    protected $sellDate;

    /**
     * @ORM\Column(type="date", nullable=false)
     *
     * @var DateTime
     */
    protected $issueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @var DateTime
     */
    protected $deadlinePayment;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $issuePlace;

    public function __construct() {
        parent::__construct();
        $this->sellDate  = new DateTime();
        $this->issueDate = new DateTime();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
} 