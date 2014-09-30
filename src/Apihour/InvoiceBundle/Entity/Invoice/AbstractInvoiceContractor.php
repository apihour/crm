<?php

namespace Apihour\InvoiceBundle\Entity\Invoice;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractInvoiceContractor
 * @package Apihour\InvoiceBundle\Entity\Invoice
 *
 * @ORM\MappedSuperclass()
 * @ORM|Entity(repositoryClass="")
 * @ORM\Table(name="invoices")
 */
abstract class AbstractInvoiceContractor {
    private $id;

    protected $name;

    protected $taxNumber;

    protected $address;
} 