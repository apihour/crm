<?php

namespace Tutto\FileBundle\FileManager;

use Tutto\FileBundle\File\File;
use Gaufrette\Adapter;

/**
 * Class AbstractFileManager
 * @package Tutto\FileBundle\FileManager
 */
abstract class AbstractFileManager {
    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        $this->setAdapter($adapter);
    }

    /**
     * @param File $file
     * @return void
     */
    abstract public function upload(File $file);

    /**
     * @return Adapter
     */
    public function getAdapter() {
        return $this->adapter;
    }

    /**
     * @param Adapter $adapter
     */
    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }
}