<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractProductContainer
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractProductContainer extends AbstractSettlement {
    /**
     * @ORM\OneToMany(targetEntity="Apihour\SettlementBundle\Entity\Settlement\SettlementHasProduct", mappedBy="settlement", cascade={"all"})
     *
     * @var SettlementHasProduct[]
     */
    protected $products;

    /**
     * @param int $type
     */
    public function __construct($type) {
        parent::__construct($type);
        $this->products = new ArrayCollection();
    }

    /**
     * @return SettlementHasProduct[]
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * @param SettlementHasProduct $product
     */
    public function addProduct(SettlementHasProduct $product) {
        $product->setSettlement($this);
        $this->products[] = $product;
    }

    /**
     * @return float
     */
    public function getPrice() {
        $price = 0.0;
        foreach ($this->getProducts() as $product) {
            $price+= $product->getProduct()->getPrice();
        }

        return $price;
    }
} 