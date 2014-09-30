<?php

namespace Tutto\SecurityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

use JsonSerializable;

/**
 * Class Role
 * @package Tutto\SecurityBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class Role implements JsonSerializable {
    const GUEST       = 'GUEST';
    const MEMBER      = 'MEMBER';
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     *
     * @var Role|null
     */
    protected $parent = null;
    
    /**
     * @ORM\Column(length=255, unique=true)
     *
     * @var string
     */
    protected $name = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Role", mappedBy="parent", cascade={"persist"})
     *
     * @var ArrayCollection
     */
    protected $children;
    
    /**
     * @param string $name
     */
    public function __construct($name = null) {
        $this->children = new ArrayCollection();
        $this->setName($name);
    }
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return Role
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param Role $parent
     * @return Role
     */
    public function setParent(Role $parent) {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName($name) {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function isAllowed(Role $role) {
        if($this->getId() === $role->getId()) {
            return true;
        } else {
            if (($parent = $this->getParent()) instanceof Role) {
                return $parent->isAllowed($role);
            }
        }

        return false;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize() {
        return array(
            'id'   => $this->getId(),
            'name' => $this->getName(),
        );
    }
}
