<?php

namespace Henry\AssetPublisherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('assetpublisher');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('assets')
                    ->children()
                        ->variableNode('publicpath')
                            ->defaultValue('web/assets')
                        ->end()
                        ->variableNode('sources')
                            ->defaultValue([])
                        ->end()
                    ->end()
                ->end() // assets
            ->end()
        ;

        return $treeBuilder;
    }
}
