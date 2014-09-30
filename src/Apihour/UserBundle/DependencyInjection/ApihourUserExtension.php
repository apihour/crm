<?php

namespace Apihour\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Class ApihourUserExtension
 * @package Apihour\UserBundle\DependencyInjection
 */
class ApihourUserExtension extends Extension {
    /**
     * @param array $config
     * @param ContainerBuilder $container
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

        $container->setParameter('apihour_user', $config);
    }
} 