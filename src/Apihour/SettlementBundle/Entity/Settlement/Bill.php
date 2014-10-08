<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Bill
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_bills")
 */
class Bill extends AbstractSettlement {

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=4, nullable=false, options={"default": 0,0})
     *
     * @var float
     */
    private $price = 0.0;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\Bill", cascade={"all"})
     * @ORM\JoinColumn(name="associated_bill_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     *
     * @var Bill
     */
    private $associatedBill;

    /**
     * @return Bill
     */
    public function getAssociatedBill() {
        return $this->associatedBill;
    }

    /**
     * @param Bill $associatedBill
     */
    public function setAssociatedBill(Bill $associatedBill) {
        $this->associatedBill = $associatedBill;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price) {
        $this->price = (float) $price;
    }

    /**
     * @return string
     */
    function getAliasName() {
        return 'bill';
    }
}