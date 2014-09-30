<?php

namespace Tutto\FileBundle\FileManager;

use Tutto\FileBundle\File\File;

/**
 * Class FileManager
 * @package Tutto\FileBundle\FileManager
 */
class FileManager extends AbstractFileManager {
    /**
     * @param File $file
     * @return void
     */
    public function upload(File $file) {
        $this->getAdapter()->write($file->getFilename(), $file->getContents());
    }
}