<?php

namespace Tutto\FileBundle\File;

/**
 * Interface FileInterface
 * @package Tutto\FileBundle\File
 */
interface FileInterface {
    public function getUri($prefix = '', $suffix = '');
} 