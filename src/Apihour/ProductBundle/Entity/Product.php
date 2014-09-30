<?php

namespace Apihour\ProductBundle\Entity;

use Apihour\ContractorBundle\Entity\Contractor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Apihour\FrontendBundle\Entity\AbstractOwnerUserAccount;
use Apihour\FrontendBundle\Entity\Category;
use Apihour\ProductBundle\Entity\Product\ProductHasFile;
use Tutto\CommonBundle\Entity\Currency;

/**
 * Class Product
 * @package Apihour\ProductBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\ProductBundle\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product extends AbstractOwnerUserAccount {
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
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(length=10, nullable=false)
     *
     * @var string
     */
    protected $type = self::TYPE_SELL;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $shortName;

    /**
     * @ORM\Column(type="decimal", precision=4)
     *
     * @var float
     */
    protected $price = 0.0;

    /**
     * @ORM\ManyToOne(targetEntity="Tutto\CommonBundle\Entity\Currency", fetch="EAGER")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
     *
     * @var Currency
     */
    protected $currency;

    /**
     * @var int
     */
    protected $vat;

    /**
     * @ORM\Column(length=20, nullable=true)
     *
     * @var string
     */
    protected $ean13;

    /**
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    protected $sold = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\FrontendBundle\Entity\Category", cascade={"all"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Category
     */
    protected $category = null;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\ContractorBundle\Entity\Contractor")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Contractor
     */
    protected $supplier = null;

    /**
     * @ORM\OneToMany(targetEntity="Apihour\ProductBundle\Entity\Product\ProductHasFile", mappedBy="product", cascade={"all"})
     *
     * @var ProductHasFile[]
     */
    protected $files;

    public function __construct() {
        parent::__construct();
        $this->files = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
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
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
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
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getShortName() {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName($shortName) {
        $this->shortName = $shortName;
    }

    /**
     * @return int
     */
    public function getVat() {
        return $this->vat;
    }

    /**
     * @param int $vat
     */
    public function setVat($vat) {
        $this->vat = $vat;
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
     * @param ProductHasFile $file
     */
    public function addFile(ProductHasFile $file) {
        $file->setProduct($this);
        $this->files[] = $file;
    }

    /**
     * @return ProductHasFile[]
     */
    public function getFiles() {
        return $this->files;
    }
} 