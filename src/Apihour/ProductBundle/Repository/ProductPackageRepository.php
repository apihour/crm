<?php

namespace Apihour\ProductBundle\Repository;

use Apihour\FrontendBundle\Repository\AbstractEntityRepository;
use Apihour\ProductBundle\Entity\ProductPackage;

/**
 * Class ProductPackageRepository
 * @package Apihour\ProductBundle\Repository
 */
class ProductPackageRepository extends AbstractEntityRepository {
    /**
     * @param ProductPackage $productPackage
     */
    public function update(ProductPackage $productPackage) {
        $this->getEntityManager()->persist($productPackage);
        $this->getEntityManager()->flush();
    }
} 