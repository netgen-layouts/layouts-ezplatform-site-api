<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\Tests\DependencyInjection\CompilerPass;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\SearchServiceAdapterPass;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

#[CoversClass(SearchServiceAdapterPass::class)]
final class SearchServiceAdapterPassTest extends AbstractContainerBuilderTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->container->addCompilerPass(new SearchServiceAdapterPass());
    }

    public function testProcessWithFilterAdapter(): void
    {
        $this->container->setParameter('netgen_layouts.ibexa_site_api.search_service_adapter', 'filter');

        $this->container->setDefinition('search_service', new Definition());
        $this->container->setDefinition('netgen.ibexa_site_api.filter_service.search_adapter', new Definition());

        $this->container->setAlias('netgen_layouts.ibexa.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ibexa.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias(
            'netgen_layouts.ibexa.search_service',
            'netgen.ibexa_site_api.filter_service.search_adapter',
        );

        $this->assertContainerBuilderHasAlias(
            'netgen_content_browser.ibexa.search_service',
            'netgen.ibexa_site_api.filter_service.search_adapter',
        );
    }

    public function testProcessWithFindAdapter(): void
    {
        $this->container->setParameter('netgen_layouts.ibexa_site_api.search_service_adapter', 'find');

        $this->container->setDefinition('search_service', new Definition());
        $this->container->setDefinition('netgen.ibexa_site_api.find_service.search_adapter', new Definition());

        $this->container->setAlias('netgen_layouts.ibexa.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ibexa.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias(
            'netgen_layouts.ibexa.search_service',
            'netgen.ibexa_site_api.find_service.search_adapter',
        );

        $this->assertContainerBuilderHasAlias(
            'netgen_content_browser.ibexa.search_service',
            'netgen.ibexa_site_api.find_service.search_adapter',
        );
    }

    public function testProcessWithNonExistingAdapterService(): void
    {
        $this->container->setParameter('netgen_layouts.ibexa_site_api.search_service_adapter', 'filter');

        $this->container->setDefinition('search_service', new Definition());

        $this->container->setAlias('netgen_layouts.ibexa.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ibexa.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias('netgen_layouts.ibexa.search_service', 'search_service');
        $this->assertContainerBuilderHasAlias('netgen_content_browser.ibexa.search_service', 'search_service');
    }

    public function testProcessWithUnsupportedAdapter(): void
    {
        $this->container->setParameter('netgen_layouts.ibexa_site_api.search_service_adapter', 'other');

        $this->container->setDefinition('search_service', new Definition());

        $this->container->setAlias('netgen_layouts.ibexa.search_service', 'search_service');
        $this->container->setAlias('netgen_content_browser.ibexa.search_service', 'search_service');

        $this->compile();

        $this->assertContainerBuilderHasAlias('netgen_layouts.ibexa.search_service', 'search_service');
        $this->assertContainerBuilderHasAlias('netgen_content_browser.ibexa.search_service', 'search_service');
    }

    public function testProcessWithEmptyContainer(): void
    {
        $this->compile();

        self::assertInstanceOf(FrozenParameterBag::class, $this->container->getParameterBag());
    }
}
