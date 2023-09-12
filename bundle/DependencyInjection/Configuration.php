<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection;

use Netgen\Layouts\Utils\BackwardsCompatibility\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder as BaseTreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class Configuration implements ConfigurationInterface
{
    public function __construct(private ExtensionInterface $extension) {}

    public function getConfigTreeBuilder(): BaseTreeBuilder
    {
        $treeBuilder = new TreeBuilder($this->extension->getAlias());
        $rootNode = $treeBuilder->getRootNode();

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
