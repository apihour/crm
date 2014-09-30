<?php

namespace Tutto\XhtmlBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class TuttoXhtmlExtension
 * @package Tutto\XhtmlBundle\DependecyInjection
 */
class TuttoXhtmlExtension extends Extension {
    /**
     * Loads a specific configuration.
     *
     * @param array $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
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