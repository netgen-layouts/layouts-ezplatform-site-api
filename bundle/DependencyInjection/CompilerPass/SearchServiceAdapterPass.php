<?php

namespace Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SearchServiceAdapterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $searchServiceAdapter = null;
        $adapterType = $container->getParameter('netgen_block_manager.site_api.search_service_adapter');
        if ($adapterType === 'filter') {
            $searchServiceAdapter = 'netgen.ezplatform_site.filter_service.search_adapter';
        } elseif ($adapterType === 'find') {
            $searchServiceAdapter = 'netgen.ezplatform_site.find_service.search_adapter';
        }

        if (!empty($searchServiceAdapter)) {
            if ($container->hasAlias('netgen_block_manager.ezpublish.search_service')) {
                $container->setAlias('netgen_block_manager.ezpublish.search_service', $searchServiceAdapter);
            }

            if ($container->hasAlias('netgen_content_browser.ezpublish.search_service')) {
                $container->setAlias('netgen_content_browser.ezpublish.search_service', $searchServiceAdapter);
            }
        }
    }
}
