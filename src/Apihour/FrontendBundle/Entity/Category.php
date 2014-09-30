<?php

namespace Apihour\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Apihour\UserBundle\Entity\User\UserAccount;

/**
 * Class Category
 * @package Apihour\FrontendBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\FrontendBundle\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 */
class Category extends AbstractOwnerUserAccount {
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
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $description = null;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\FrontendBundle\Entity\Category", inversedBy="children", fetch="EAGER")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     *
     * @var Category|null
     */
    protected $parent = null;

    /**
     * @ORM\OneToMany(targetEntity="Apihour\FrontendBundle\Entity\Category", mappedBy="parent", fetch="EAGER")
     *
     * @var Category[]
     */
    protected $children;

    public function __construct() {
        parent::__construct();
        $this->children = new ArrayCollection();
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
     * @param UserAccount $ownerUserAccount
     */
    public function setOwnerUserAccount(UserAccount $ownerUserAccount) {
        $this->ownerUserAccount = $ownerUserAccount;
    }

    /**
     * @return Category|null
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param Category|null $parent
     */
    public function setParent($parent) {
        $this->parent = $parent;
    }

    /**
     * @param Category $category
     */
    public function addChild(Category $category) {
        $this->children[] = $category;
    }

    /**
     * @return Category[]|ArrayCollection
     */
    public function getChildren() {
        return $this->children;
    }
} 