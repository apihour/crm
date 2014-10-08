<?php

namespace Apihour\ContractorBundle\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * Class Seller
 * @package Apihour\ContractorBundle\Entity
 *
 * @Entity()
 */
class Seller extends AbstractContractor {
    /**
     * @return string
     */
    public function getAliasName() {
        return 'seller';
    }
}