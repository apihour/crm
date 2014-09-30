<?php

namespace Apihour\UserBundle\FileManager;

use Gaufrette\Adapter;
use Gaufrette\Filesystem;
use Gregwar\ImageBundle\ImageHandler;
use Gregwar\ImageBundle\Services\ImageHandling;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tutto\FileBundle\Entity\File;

/**
 * Class AvatarFileManager
 * @package Apihour\UserBundle\FileManager
 */
class AvatarFileManager {
    /**
     * @var ImageHandling
     */
    protected $imageHandling;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * @param ImageHandling $imageHandling
     * @param Adapter $adapter
     */
    public function __construct(ImageHandling $imageHandling, Adapter $adapter) {
        $this->setImageHandling($imageHandling);
        $this->setAdapter($adapter);
    }

    /**
     * Upload Avatar files
     *
     * @param File $file
     */
    public function upload(File $file) {
        if ($file->getFile() instanceof UploadedFile) {
            $up = $file->getFile()->move('public/tmp');

            /** @var ImageHandler $images */
            $images['xl']     = $this->getImageHandling()->open($up->getPathname());
            $images['medium'] = $this->getImageHandling()->open($up->getPathname());
            $images['small']  = $this->getImageHandling()->open($up->getPathname());

            $images['xl']->cropResize(150, 150);
            $images['medium']->cropResize(50, 50);
            $images['small']->cropResize(30, 30);

            $this->getAdapter()->write($file->getUri('', '_xl'), file_get_contents($images['xl']->cacheFile('guess', 100, true)));
            $this->getAdapter()->write($file->getUri('', '_medium'), file_get_contents($images['medium']->cacheFile('guess', 100, true)));
            $this->getAdapter()->write($file->getUri('', '_small'), file_get_contents($images['small']->cacheFile('guess', 100, true)));
        }
    }

    /**
     * Delete avatar files
     *
     * @param File $file
     */
    public function delete(File $file) {
        $filesystem = new Filesystem($this->getAdapter());
        $filesystem->delete($file->getUri('', '_xl'));
        $filesystem->delete($file->getUri('', '_medium'));
        $filesystem->delete($file->getUri('', '_small'));
    }

    /**
     * @return Adapter
     */
    public function getAdapter() {
        return $this->adapter;
    }

    /**
     * @param Adapter $adapter
     */
    public function setAdapter(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    /**
     * @return ImageHandling
     */
    public function getImageHandling() {
        return $this->imageHandling;
    }

    /**
     * @param ImageHandling $imageHandling
     */
    public function setImageHandling(ImageHandling $imageHandling) {
        $this->imageHandling = $imageHandling;
    }
}