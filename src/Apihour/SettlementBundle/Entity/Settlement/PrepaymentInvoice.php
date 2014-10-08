<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PrepaymentInvoice
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_prepayment_invoice")
 */
class PrepaymentInvoice extends AbstractProductContainer {
    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\Settlement\FinalInvoice", inversedBy="prepaymentInvoices", cascade={"all"})
     * @ORM\JoinColumn(name="final_invoice_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var FinalInvoice
     */
    private $finalInvoice;

    /**
     * @return string
     */
    function getAliasName() {
        return 'prepayment_invoice';
    }
}