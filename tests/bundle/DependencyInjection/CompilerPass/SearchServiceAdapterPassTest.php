<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteAPIBlockManagerBundle\Tests\DependencyInjection\CompilerPass;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

final class SearchServiceAdapterPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass::process
     */
    public function testProcessWithFilterAdapter(): void
    {
        $this->container->setParameter('netgen_block_manager.site_api.search_service_adapter', 'filter');

        $this->container->setDefinition('search_service', new Definition());
        $this->container->setDefinition('netgen.ezplatform_site.filter_service.search_adapter', new Definition());

        $this->container->setAlias('netgen_block_manager.ezplatform.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ezplatform.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias(
            'netgen_block_manager.ezplatform.search_service',
            'netgen.ezplatform_site.filter_service.search_adapter'
        );

        $this->assertContainerBuilderHasAlias(
            'netgen_content_browser.ezplatform.search_service',
            'netgen.ezplatform_site.filter_service.search_adapter'
        );
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass::process
     */
    public function testProcessWithFindAdapter(): void
    {
        $this->container->setParameter('netgen_block_manager.site_api.search_service_adapter', 'find');

        $this->container->setDefinition('search_service', new Definition());
        $this->container->setDefinition('netgen.ezplatform_site.find_service.search_adapter', new Definition());

        $this->container->setAlias('netgen_block_manager.ezplatform.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ezplatform.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias(
            'netgen_block_manager.ezplatform.search_service',
            'netgen.ezplatform_site.find_service.search_adapter'
        );

        $this->assertContainerBuilderHasAlias(
            'netgen_content_browser.ezplatform.search_service',
            'netgen.ezplatform_site.find_service.search_adapter'
        );
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass::process
     */
    public function testProcessWithNonExistingAdapterService(): void
    {
        $this->container->setParameter('netgen_block_manager.site_api.search_service_adapter', 'filter');

        $this->container->setDefinition('search_service', new Definition());

        $this->container->setAlias('netgen_block_manager.ezplatform.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ezplatform.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias('netgen_block_manager.ezplatform.search_service', 'search_service');
        $this->assertContainerBuilderHasAlias('netgen_content_browser.ezplatform.search_service', 'search_service');
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass::process
     */
    public function testProcessWithUnsupportedAdapter(): void
    {
        $this->container->setParameter('netgen_block_manager.site_api.search_service_adapter', 'other');

        $this->container->setDefinition('search_service', new Definition());

        $this->container->setAlias('netgen_block_manager.ezplatform.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ezplatform.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias('netgen_block_manager.ezplatform.search_service', 'search_service');
        $this->assertContainerBuilderHasAlias('netgen_content_browser.ezplatform.search_service', 'search_service');
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass::process
     */
    public function testProcessWithEmptyContainer(): void
    {
        $this->compile();

        self::assertInstanceOf(FrozenParameterBag::class, $this->container->getParameterBag());
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SearchServiceAdapterPass());
    }
}
