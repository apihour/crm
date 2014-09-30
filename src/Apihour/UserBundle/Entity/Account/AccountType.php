<?php

namespace Apihour\UserBundle\Entity\Account;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AccountType
 * @package Apihour\UserBundle\Entity\Account
 *
 * @ORM\Entity()
 * @ORM\Table(name="accounts_types")
 */
class AccountType {
    const TYPE_FREE     = 1;
    const TYPE_PREMIUM  = 2;
    const TYPE_SILVER   = 3;
    const TYPE_GOLD     = 4;
    const TYPE_PLATINUM = 5;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=255)
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
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
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