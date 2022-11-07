<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle;

use Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class NetgenLayoutsIbexaSiteApiBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CompilerPass\SearchServiceAdapterPass());
        $container->addCompilerPass(new CompilerPass\DefaultAppPreviewPass());
        $container->addCompilerPass(new CompilerPass\DefaultContentBrowserPreviewPass());
        $container->addCompilerPass(new CompilerPass\IbexaConfigProviderPass());
    }
}
