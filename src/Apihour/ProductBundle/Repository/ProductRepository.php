<?php

namespace Apihour\ProductBundle\Repository;

use Apihour\FrontendBundle\Entity\Category;
use Apihour\FrontendBundle\Repository\AbstractEntityRepository;
use Apihour\FrontendBundle\Repository\CategoryRepository;
use Apihour\ProductBundle\Entity\Product;
use DateTime;

/**
 * Class ProductRepository
 * @package Apihour\ProductBundle\Repository
 */
class ProductRepository extends AbstractEntityRepository {
    /**
     * @param Product $product
     */
    public function update($product) {
        if ($product->getCategory() !== null) {
            /** @var CategoryRepository $categoryRepository */
            $categoryRepository = $this->getRepository(Category::class);

            $categoryRepository->update($product->getCategory());
        }

        if ($product->getOwnerUserAccount() === null) {
            $product->setOwnerUserAccount($this->getCurrentUserAccount());
        }
        if ($product->getCreatedBy() === null) {
            $product->setCreatedBy($this->getCurrentUserAccount());
        }

        $product->setModifiedBy($this->getCurrentUserAccount());
        $product->setModifiedAt(new DateTime());

        $this->getEm()->persist($product);
        $this->getEm()->flush();
    }
} 