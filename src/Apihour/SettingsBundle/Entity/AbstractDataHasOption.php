<?php

namespace Apihour\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tutto\CommonBundle\Entity\AbstractEntity;

/**
 * Class AbstractDataHasOption
 * @package Apihour\SettingsBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractDataHasOption extends AbstractEntity {
    /**
     * @ORM\Column(type="array", nullable=false)
     *
     * @var mixed
     */
    private $value;

    /**
     * @return AbstractDataOption
     */
    abstract public function getOption();

    /**
     * @param AbstractDataOption $option
     * @return void
     */
    abstract public function setOption(AbstractDataOption $option);

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }
} 