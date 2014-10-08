<?php

namespace Tutto\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Currency
 * @package Tutto\CommonBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="currencies", indexes={@ORM\Index(name="unique_currency_name", columns={"name"})})
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
    protected $name;

    /**
     * @ORM\Column(length=4, nullable=false)
     *
     * @var string
     */
    private $lang;

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
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->currency = $name;
    }

    /**
     * @return string
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang) {
        $this->lang = $lang;
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