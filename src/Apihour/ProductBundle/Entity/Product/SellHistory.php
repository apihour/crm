<?php

namespace Apihour\ProductBundle\Entity\Product;

use Apihour\ProductBundle\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SellHistory
 * @package Apihour\ProductBundle\Entity\Product
 *
 * @ORM\Entity()
 * @ORM\Table(name="products_has_sell_history")
 */
class SellHistory {
    /**
     * @ORM\Id()()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column()
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\JoinColumn()
     *
     * @var Product
     */
    protected $product;

    protected $sold = 0;

    protected $soldAt;
} 