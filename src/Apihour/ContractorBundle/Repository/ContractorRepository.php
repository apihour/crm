<?php

namespace Apihour\ContractorBundle\Repository;

use Apihour\ContractorBundle\Entity\AbstractContractor;
use Apihour\ContractorBundle\Entity\Contractor;
use Tutto\CommonBundle\Repository\AbstractEntityRepository;

/**
 * Class ContractorRepository
 * @package Apihour\ContractorBundle\Repository
 */
class ContractorRepository extends AbstractEntityRepository {
    /**
     * @param AbstractContractor $contractor
     */
    public function update($contractor) {
        parent::update($contractor);
    }
} 