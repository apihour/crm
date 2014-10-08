<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProformaInvoice
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_proforma_invoices")
 */
class ProformaInvoice extends AbstractProductContainer {
    /**
     * @return string
     */
    function getAliasName() {
        return 'proforma_invoice';
    }
}