<?php

namespace Apihour\ProductBundle\Entity\Product;

use Apihour\FileBundle\Entity\File;
use Apihour\ProductBundle\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductHasFile
 * @package Apihour\ProductBundle\Entity\Product
 *
 * @ORM\Entity()
 * @ORM\Table(name="products_has_files")
 */
class ProductHasFile {
    const TYPE_IMAGE = 1;
    const TYPE_DOCUMENT = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     *
     * @var int
     */
    protected $type = self::TYPE_IMAGE;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $isVisible = true;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\ProductBundle\Entity\Product", inversedBy="files")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Product
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\FileBundle\Entity\File", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var File
     */
    protected $file;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return File
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file) {
        $this->file = $file;
    }

    /**
     * @return boolean
     */
    public function isVisible() {
        return $this->isVisible;
    }

    /**
     * @param boolean $isVisible
     */
    public function setIsVisible($isVisible) {
        $this->isVisible = (boolean) $isVisible;
    }

    /**
     * @return Product
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product) {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type) {
        $this->type = (int) $type;
    }
} 