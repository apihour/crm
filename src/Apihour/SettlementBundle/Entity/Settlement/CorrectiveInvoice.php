<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Apihour\SettlementBundle\Entity\Settlement\CorrectiveInvoice\CorrectiveProduct;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CorrectiveInvoice
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_corrective_invoices")
 */
class CorrectiveInvoice extends AbstractSettlement {

    /**
     * @ORM\OneToMany(targetEntity="Apihour\SettlementBundle\Entity\Settlement\CorrectiveInvoice\CorrectiveProduct", mappedBy="correctiveInvoice", cascade={"all"})
     *
     * @var CorrectiveProduct[]
     */
    protected $products;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\Invoice", cascade={"all"})
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Invoice
     */
    protected $invoice;

    /**
     * @param int $type
     */
    public function __construct($type) {
        parent::__construct($type);
        $this->products = new ArrayCollection();
    }


    /**
     * @return CorrectiveProduct[]
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * @param CorrectiveProduct $product
     */
    public function addProduct(CorrectiveProduct $product) {
        $product->setCorrectiveInvoice($this);
        $this->products[] = $product;
    }

    /**
     * @return float
     */
    function getPrice() {
        $price = 0.0;
        foreach ($this->getProducts() as $product) {
            $price = $product->getOldProduct()->getPrice() - $product->getNewProduct()->getPrice();
        }

        return $price;
    }

    /**
     * @return string
     */
    function getAliasName() {
        return 'corrective_invoice';
    }
}