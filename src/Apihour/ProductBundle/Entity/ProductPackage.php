<?php

namespace Apihour\ProductBundle\Entity;

use Apihour\FrontendBundle\Entity\AbstractOwnerUserAccount;

use Apihour\FrontendBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductPackage
 * @package Apihour\ProductBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\ProductBundle\Repository\ProductPackageRepository")
 * @ORM\Table(name="products_packages")
 */
class ProductPackage extends AbstractOwnerUserAccount {
    const TYPE_SELL = 'sell';
    const TYPE_BUY  = 'buy';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=255, nullable=false)
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $shortName;

    /**
     * @ORM\Column(length=10, nullable=false)
     *
     * @var string
     */
    protected $type = self::TYPE_SELL;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\FrontendBundle\Entity\Category", cascade={"all"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Category
     */
    protected $category = null;

    /**
     * @ORM\ManyToMany(targetEntity="Apihour\ProductBundle\Entity\Product", fetch="EAGER")
     * @ORM\JoinTable(name="products_has_packages",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="package_id", referencedColumnName="id")}
     * )
     *
     * @var Product[]
     */
    protected $products;

    public function __construct() {
        parent::__construct();
        $this->products = new ArrayCollection();
    }
} 