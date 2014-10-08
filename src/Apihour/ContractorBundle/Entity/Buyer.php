<?php

namespace Apihour\ContractorBundle\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * Class Buyer
 * @package Apihour\ContractorBundle\Entity
 *
 * @Entity()
 */
class Buyer extends AbstractContractor {
    /**
     * @return string
     */
    public function getAliasName() {
        return 'buyer';
    }
}