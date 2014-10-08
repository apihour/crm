<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Doctrine\ORM\Mapping as ORM;
use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class Product
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_products")
 */
class SettlementProduct extends AbstractEntity {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=4, nullable=false, options={"default": 0,0})
     *
     * @var float
     */
    private $price = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=4, nullable=false, options={"default": 0,0})
     *
     * @var float
     */
    private $quantity = 0.0;

    /**
     * @ORM\Column(length=10, nullable=false)
     *
     * @var string
     */
    private $unit;

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
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getUnit() {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit) {
        $this->unit = $unit;
    }
} 