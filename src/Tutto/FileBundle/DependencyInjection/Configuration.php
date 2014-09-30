<?php

namespace Tutto\FileBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Tutto\FileBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface {
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('tutto_file');

        $rootNode->children()
            ->scalarNode('server')
            ->defaultValue('/')
            ->end();

        return $treeBuilder;
    }
}