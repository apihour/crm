<?php

namespace Tutto\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Currency
 * @package Tutto\CommonBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="currencies", indexes={@ORM\Index(name="unique_currency_name", columns={"currency"})})
 */
class Currency extends AbstractEntity {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=4, nullable=false)
     *
     * @var string
     */
    protected $currency;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $description;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }
}