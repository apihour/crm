<?php

namespace Apihour\FileBundle\Repository;

use Apihour\FileBundle\Entity\File;
use Tutto\CommonBundle\Repository\AbstractEntityRepository;
use ReflectionClass;
use BadMethodCallException;

/**
 * Class FileRepository
 * @package Apihour\FileBundle\Repository
 */
class FileRepository extends AbstractEntityRepository {
    /**
     * @param File $file
     * @param array $options
     * @return File
     */
    public function prepareNewFile(File $file = null, array $options = []) {
        if ($file === null) {
            $file = new File();
        }

        $class = new ReflectionClass($file);
        foreach ($options as $key => $value) {
            $methodName = 'set'.ucfirst($key);
            if ($class->hasMethod($methodName) && ($method = $class->getMethod($methodName)) && $method->isPublic()) {
                $method->invokeArgs($file, (array) $value);
            } else {
                throw new BadMethodCallException("Method: '{$methodName}' not exists or is non public.");
            }
        }

        return $file;
    }
} 