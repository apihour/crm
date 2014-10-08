<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FinalInvoice
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_final_invoice")
 */
class FinalInvoice extends AbstractProductContainer {
    /**
     * @ORM\OneToMany(targetEntity="Apihour\SettlementBundle\Entity\Settlement\PrepaymentInvoice", mappedBy="finalInvoice", cascade={"all"})
     *
     * @var PrepaymentInvoice[]
     */
    private $prepaymentInvoices;

    /**
     * @return string
     */
    function getAliasName() {
        return 'final_invoice';
    }
}