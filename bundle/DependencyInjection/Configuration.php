<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection;

use Netgen\Bundle\BlockManagerBundle\DependencyInjection\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder as BaseTreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Extension\ExtensionInterface
     */
    private $extension;

    public function __construct(ExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

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
