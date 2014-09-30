<?php

namespace Tutto\FileBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tutto\FileBundle\File\FileInterface;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class FileManagerExtension
 * @package Tutto\FileBundle\Twig
 */
class FileManagerExtension extends Twig_Extension implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->setContainer($container);
    }

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            new Twig_SimpleFunction('file_image', [$this, 'file_image'])
        ];
    }

    /**
     * @param FileInterface $file
     * @param string $prefix
     * @param string $suffix
     * @return mixed
     */
    public function file_image($file, $prefix = '', $suffix = '') {
        $config = $this->container->getParameter('tutto_file');
        $server = '';
        if (isset($config['server'])) {
            $server = rtrim($config['server'], '/');
        }

        if ($file instanceof FileInterface) {
            $uri = $file->getUri($prefix, $suffix);
        } elseif (is_string($file)) {
            $uri = $this->parsePrefixAndSuffix($file, $prefix, $suffix);
        } else {
            throw new \LogicException('File needs to be FileInterface or string (file path)');
        }

        return $server . '/' . ltrim($uri, '/');
    }

    /**
     * @param $path
     * @param string $prefix
     * @param string $suffix
     * @return array|string
     */
    protected function parsePrefixAndSuffix($path, $prefix = '', $suffix = '') {
        $pathParts = explode('/', $path);
        if (count($pathParts) > 0) {
            $filenameParts = explode('.', $pathParts[count($pathParts) - 1]);
            unset($pathParts[count($pathParts) - 1]);
            $base = join('/', $pathParts);
            return count($filenameParts) > 0
                ? rtrim($base, '/'). '/' . $prefix . $filenameParts[0] . $suffix . '.' .$filenameParts[1]
                : $path;
        }

        return $path;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'apihour_file_manager';
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}