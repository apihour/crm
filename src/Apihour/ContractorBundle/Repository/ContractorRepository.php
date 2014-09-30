<?php
/**
 * Created by PhpStorm.
 * User: pkrawczyk
 * Date: 17.09.14
 * Time: 13:35
 */

namespace Apihour\ContractorBundle\Repository;
use Apihour\ContractorBundle\Entity\Contractor;
use Tutto\CommonBundle\PropertyAccess\PropertyAccessor;
use Tutto\CommonBundle\Repository\AbstractEntityRepository;

/**
 * Class ContractorRepository
 * @package Apihour\ContractorBundle\Repository
 */
class ContractorRepository extends AbstractEntityRepository {

    /**
     * @param Contractor $contractor
     */
    public function update(Contractor $contractor) {
        $this->getEm()->persist($contractor);
        $this->getEm()->flush();
    }

    /**
     * @param Contractor $contractor
     */
    public function delete(Contractor $contractor) {
        $this->getEm()->remove($contractor);
        $this->getEm()->flush();
    }
} 