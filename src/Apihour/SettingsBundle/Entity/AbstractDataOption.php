<?php

namespace Apihour\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DataOptionEntityInterface
 * @package Apihour\SettingsBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractDataOption {
    /**
     * @ORM\Column(name="`group`", length=255, nullable=false)
     *
     * @var string
     */
    private $group;

    /**
     * @ORM\Column(length=255, nullable=false)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="`default`", type="array", nullable=false)
     *
     * @var mixed
     */
    private $default;

    /**
     * @ORM\Column(length=255, nullable=false, options={"default": "text"})
     *
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(type="array", nullable=false)
     *
     * @var array
     */
    private $constraints;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    private $shortDescription;

    /**
     * @return string
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup($group) {
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDefault() {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default) {
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getConstraints() {
        return $this->constraints;
    }

    /**
     * @param array $constraints
     */
    public function setConstraints(array $constraints) {
        $this->constraints = $constraints;
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

    /**
     * @return string
     */
    public function getShortDescription() {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
    }
} 