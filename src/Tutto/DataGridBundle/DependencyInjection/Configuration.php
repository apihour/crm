<?php

namespace Tutto\DataGridBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Tutto\DataGridBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface {
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('tutto_data_grid');

        $rootNode->children()
            ->scalarNode('template')
            ->defaultValue('@TuttoDataGrid/layout.html.twig')
            ->end();

        return $treeBuilder;
    }
}