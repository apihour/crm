<?php

namespace Apihour\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Apihour\UserBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface {
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('apihour_user');

        $rootNode->children()
            ->scalarNode('avatar_absolute_path')
            ->defaultValue('')
            ->end()
            ->scalarNode('avatar_base_path')
            ->defaultValue('public/users/accounts/{getId}/')
            ->end();

        return $treeBuilder;
    }
}