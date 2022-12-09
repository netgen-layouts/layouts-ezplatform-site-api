<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\Tests\DependencyInjection\CompilerPass;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\IbexaConfigProviderPass;
use stdClass;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

final class IbexaConfigProviderPassTest extends AbstractContainerBuilderTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->container->addCompilerPass(new IbexaConfigProviderPass());
    }

    /**
     * @covers \Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\IbexaConfigProviderPass::process
     */
    public function testProcessWithFilterAdapter(): void
    {
        $this->container->setDefinition(
            'netgen_layouts.ibexa.block.block_definition.config_provider.ibexa',
            new Definition(stdClass::class, ['foo', 'bar', 'baz', 'bax']),
        );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'netgen_layouts.ibexa.block.block_definition.config_provider.ibexa',
            3,
            'ngcontent_view',
        );
    }

    /**
     * @covers \Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\IbexaConfigProviderPass::process
     */
    public function testProcessWithEmptyContainer(): void
    {
        $this->compile();

        self::assertInstanceOf(FrozenParameterBag::class, $this->container->getParameterBag());
    }
}
