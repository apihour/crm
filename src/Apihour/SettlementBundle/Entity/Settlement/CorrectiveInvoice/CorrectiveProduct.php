<?php

namespace Apihour\SettlementBundle\Entity\Settlement\CorrectiveInvoice;

use Apihour\SettlementBundle\Entity\Settlement\CorrectiveInvoice;
use Apihour\SettlementBundle\Entity\Settlement\SettlementProduct;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class CorrectiveProduct
 * @package Apihour\SettlementBundle\Entity\Settlement\CorrectiveInvoice
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_corrective_invoices_has_products")
 */
class CorrectiveProduct {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\CorrectiveInvoice", inversedBy="products", cascade={"all"})
     * @ORM\JoinColumn(name="corrective_invoice_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var CorrectiveInvoice
     */
    protected $correctiveInvoice;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\SettlementProduct", cascade={"all"})
     * @ORM\JoinColumn(name="old_product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var SettlementProduct
     */
    protected $oldProduct;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\SettlementProduct", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="new_product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var SettlementProduct
     */
    protected $newProduct;

    /**
     * @return CorrectiveInvoice
     */
    public function getCorrectiveInvoice() {
        return $this->correctiveInvoice;
    }

    /**
     * @param CorrectiveInvoice $correctiveInvoice
     */
    public function setCorrectiveInvoice($correctiveInvoice) {
        $this->correctiveInvoice = $correctiveInvoice;
    }

    /**
     * @return SettlementProduct
     */
    public function getNewProduct() {
        return $this->newProduct;
    }

    /**
     * @param SettlementProduct $newProduct
     */
    public function setNewProduct($newProduct) {
        $this->newProduct = $newProduct;
    }

    /**
     * @return SettlementProduct
     */
    public function getOldProduct() {
        return $this->oldProduct;
    }

    /**
     * @param SettlementProduct $oldProduct
     */
    public function setOldProduct($oldProduct) {
        $this->oldProduct = $oldProduct;
    }
} 