<?php

namespace Netgen\Bundle\SiteAPIBlockManagerBundle;

use Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class NetgenSiteAPIBlockManagerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new SearchServiceAdapterPass());
    }
}
