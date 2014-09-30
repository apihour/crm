<?php

namespace Apihour\UserBundle\Entity\Account;

use Doctrine\ORM\Mapping as ORM;

use Tutto\CommonBundle\Tools\Status;
use Tutto\UserBundle\Entity\Account;

/**
 * Class AccountPrivilege
 * @package Apihour\UserBundle\Entity\Account
 *
 * @ORM\Entity()
 * @ORM\Table(name="accounts_privileges")
 */
class AccountPrivilege {
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
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $defaultValue;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $status = Status::ENABLED;

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

    /**
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDefaultValue() {
        return $this->defaultValue;
    }

    /**
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
    }
}