<?php

namespace Apihour\FrontendBundle\Entity;

use Apihour\UserBundle\Entity\User\UserAccount;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tag
 * @package Apihour\FrontendBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="tags")
 */
class Tag extends AbstractOwnerUserAccount {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=255, nullable=false)
     *
     * @var string
     */
    protected $name;

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
        $this->name = $name;
    }
} 