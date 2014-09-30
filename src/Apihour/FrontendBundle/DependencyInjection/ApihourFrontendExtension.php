<?php

namespace Apihour\FrontendBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Class ApihourFrontendExtension
 * @package Apihour\FrontendBundle\DependencyInjection
 */
class ApihourFrontendExtension extends Extension{
    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    public function load(array $config, ContainerBuilder $container) {
        $path     = __DIR__.'/../Resources/config';
        $filename = 'services.yml';
        $loader   = new YamlFileLoader(
            $container,
            new FileLocator($path)
        );

        if(realpath("{$path}/{$filename}")) {
            $loader->load($filename);
        }
    }
} 