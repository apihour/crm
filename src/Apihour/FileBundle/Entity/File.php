<?php

namespace Apihour\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Apihour\UserBundle\Entity\User;
use Tutto\FileBundle\Entity\File as BaseFile;

/**
 * Class File
 * @package Apihour\FileBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Apihour\FileBundle\Repository\FileRepository")
 * @ORM\Table(name="files")
 */
class File extends BaseFile {
    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", onDelete="SET NULL")
     *
     * @var User
     */
    protected $createdBy = null;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="modified_by", referencedColumnName="id", onDelete="SET NULL")
     *
     * @var User
     */
    protected $modifiedBy = null;

    /**
     * @return User
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     */
    public function setCreatedBy(User $createdBy) {
        $this->createdBy = $createdBy;
    }

    /**
     * @return User
     */
    public function getModifiedBy() {
        return $this->modifiedBy;
    }

    /**
     * @param User $modifiedBy
     */
    public function setModifiedBy(User $modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }
} 