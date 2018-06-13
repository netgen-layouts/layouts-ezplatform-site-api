<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('netgen_site_api_block_manager');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->enumNode('search_service_adapter')
                    ->defaultValue(null)
                    ->values([null, 'filter', 'find'])
                ->end()
            ->end();

        return $treeBuilder;
    }
}
