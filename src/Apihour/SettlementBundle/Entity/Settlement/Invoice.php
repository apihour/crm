<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Invoice
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_invoices")
 */
class Invoice extends AbstractProductContainer {
    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\ProformaInvoice", cascade={"all"})
     * @ORM\JoinColumn(name="proforma_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var ProformaInvoice
     */
    private $proforma;

    /**
     * @return string
     */
    function getAliasName() {
        return 'invoice';
    }
}