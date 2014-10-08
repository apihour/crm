<?php

namespace Apihour\ContractorBundle\Entity\Contractor;

use Apihour\ContractorBundle\Entity\AbstractContractor;
use Apihour\SettingsBundle\Entity\AbstractDataHasOption;
use Apihour\SettingsBundle\Entity\AbstractDataOption;
use Doctrine\ORM\Mapping as ORM;
use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class ContractorHasOption
 * @package Apihour\ContractorBundle\Entity\Contractor
 *
 * @ORM\Entity()
 * @ORM\Table(name="contractors_has_options", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique_option", columns={"contractor_id", "option_id"})
 * })
 */
class ContractorHasOption extends AbstractDataHasOption {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\ContractorBundle\Entity\AbstractContractor", inversedBy="options", cascade={"all"})
     * @ORM\JoinColumn(name="contractor_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var AbstractContractor
     */
    protected $contractor;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\ContractorBundle\Entity\Contractor\ContractorOption", cascade={"all"})
     * @ORM\JoinColumn(name="option_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var ContractorOption
     */
    protected $option;

    /**
     * @param AbstractContractor $contractor
     * @param ContractorOption $option
     * @param null $value
     */
    public function __construct(AbstractContractor $contractor = null, ContractorOption $option = null, $value = null) {
        $this->setContractor($contractor);
        $this->setOption($option);
        $this->setValue($value);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return AbstractContractor
     */
    public function getContractor() {
        return $this->contractor;
    }

    /**
     * @return ContractorOption
     */
    public function getOption() {
        return $this->option;
    }

    /**
     * @param AbstractContractor $contractor
     */
    public function setContractor(AbstractContractor $contractor) {
        $this->contractor = $contractor;
    }

    /**
     * @param AbstractDataOption $option
     */
    public function setOption(AbstractDataOption $option) {
        $this->option = $option;
    }
} 