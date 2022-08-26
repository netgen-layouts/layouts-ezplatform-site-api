<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class EzPlatformConfigProviderPass implements CompilerPassInterface
{
    private const SERVICE_NAME = 'netgen_layouts.ezplatform.block.block_definition.config_provider.ezplatform';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(self::SERVICE_NAME)) {
            return;
        }

        $container->findDefinition(self::SERVICE_NAME)
            ->replaceArgument(3, 'ngcontent_view');
    }
}
