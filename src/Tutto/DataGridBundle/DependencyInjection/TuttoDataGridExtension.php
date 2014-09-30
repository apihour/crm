<?php

namespace Tutto\DataGridBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class TuttoDataGridExtension
 * @package Tutto\DataGridBundle\DependencyInjection
 */
class TuttoDataGridExtension extends Extension {
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
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $config);

        $path     = __DIR__.'/../Resources/config';
        $filename = 'services.yml';
        $loader   = new YamlFileLoader(
            $container,
            new FileLocator($path)
        );

        if(realpath("{$path}/{$filename}")) {
            $loader->load($filename);
        }

        $container->setParameter('tutto_data_grid', $config);
    }
}