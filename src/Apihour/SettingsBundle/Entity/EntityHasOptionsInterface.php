<?php

namespace Apihour\SettingsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface EntityHasOptionsInterface
 * @package Apihour\SettingsBundle\Entity
 */
interface EntityHasOptionsInterface {
    /**
     * @return AbstractDataHasOption
     */
    public function getOptions();

    /**
     * @param ArrayCollection $options
     * @return void
     */
    public function setOptions(ArrayCollection $options);
} 