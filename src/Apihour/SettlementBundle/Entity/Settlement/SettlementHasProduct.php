<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SettlementHasProduct
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_has_settlements_products")
 */
class SettlementHasProduct {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\AbstractSettlement", inversedBy="products", cascade={"all"})
     * @ORM\JoinColumn(name="settlement_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var AbstractSettlement
     */
    protected $settlement;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\SettlementProduct", cascade={"all"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var SettlementProduct
     */
    protected $product;

    public function __construct(SettlementProduct $product = null) {

    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return SettlementProduct
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * @param SettlementProduct $product
     */
    public function setProduct(SettlementProduct $product) {
        $this->product = $product;
    }

    /**
     * @return AbstractSettlement
     */
    public function getSettlement() {
        return $this->settlement;
    }

    /**
     * @param AbstractSettlement $settlement
     */
    public function setSettlement(AbstractSettlement $settlement) {
        $this->settlement = $settlement;
    }
} 