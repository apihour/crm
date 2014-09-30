<?php

namespace Tutto\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Tutto\CommonBundle\Entity\AbstractEntity;
use Tutto\FileBundle\File\FileInterface;

/**
 * Class File
 * @package Tutto\FileBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class File extends AbstractEntity implements FileInterface {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $basePath = '/';

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $filename;

    /**
     * @ORM\Column(length=10)
     *
     * @var string
     */
    protected $ext;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $description;

    /**
     * @Assert\File(
     *      maxSize = "20000",
     *      mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *      mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     *
     * @var UploadedFile
     */
    protected $file;

    /**
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file = null) {
        if ($file !== null) {
            $this->setFile($file);
            parent::__construct();
        }
    }

    /**
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file) {
        $this->file = $file;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBasePath() {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getExt() {
        return $this->ext;
    }

    /**
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getFullFilename() {
        return $this->getFilename().'.'.$this->getExt();
    }

    /**
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public function getUri($prefix = '', $suffix = '') {
        $basePath = rtrim(preg_replace('/^\\\$/D', '/', $this->getBasePath()), '/').'/';
        $filename = $this->getFilename();

        if (!empty($prefix)) {
            $filename = $prefix . $filename;
        }

        if (!empty($suffix)) {
            $filename.= $suffix;
        }

        return $basePath.$filename . '.' . $this->getExt();
    }

    /**
     * @return boolean
     */
    public function isDeleted() {
        return $this->isDeleted;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @param string $ext
     */
    public function setExt($ext) {
        $this->ext = $ext;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }
} 