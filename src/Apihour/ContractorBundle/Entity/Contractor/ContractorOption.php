<?php

namespace Apihour\ContractorBundle\Entity\Contractor;

use Doctrine\ORM\Mapping as ORM;
use Apihour\SettingsBundle\Entity\AbstractDataOption;

/**
 * Class ContractorOption
 * @package Apihour\ContractorBundle\Entity\Contractor
 *
 * @ORM\Entity()
 * @ORM\Table(name="contractors_options")
 */
class ContractorOption extends AbstractDataOption {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
} 