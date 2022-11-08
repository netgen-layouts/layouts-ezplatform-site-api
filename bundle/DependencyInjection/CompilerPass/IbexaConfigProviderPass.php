<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class IbexaConfigProviderPass implements CompilerPassInterface
{
    private const SERVICE_NAME = 'netgen_layouts.ibexa.block.block_definition.config_provider.ibexa';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(self::SERVICE_NAME)) {
            return;
        }

        $container->findDefinition(self::SERVICE_NAME)
            ->replaceArgument(3, 'ng_content_view');
    }
}
