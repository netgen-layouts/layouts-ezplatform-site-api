<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsEzPlatformSiteApiBundle;

use Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class NetgenLayoutsEzPlatformSiteApiBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SearchServiceAdapterPass());
    }
}
