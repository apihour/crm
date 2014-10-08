<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contractor
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_has_contractors")
 */
class Contractor {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(length=255)
     *
     * @var string
     */
    private $taxNumber;
} 