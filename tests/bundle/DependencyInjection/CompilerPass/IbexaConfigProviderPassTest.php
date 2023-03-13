<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\Tests\DependencyInjection\CompilerPass;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\IbexaConfigProviderPass;
use PHPUnit\Framework\Attributes\CoversClass;
use stdClass;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

#[CoversClass(IbexaConfigProviderPass::class)]
final class IbexaConfigProviderPassTest extends AbstractContainerBuilderTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->container->addCompilerPass(new IbexaConfigProviderPass());
    }

    public function testProcess(): void
    {
        $this->container->setDefinition(
            'netgen_layouts.ibexa.block.block_definition.config_provider.ibexa',
            new Definition(stdClass::class, ['foo', 'bar', 'baz', 'bax']),
        );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'netgen_layouts.ibexa.block.block_definition.config_provider.ibexa',
            3,
            'ng_content_view',
        );
    }

    public function testProcessWithEmptyContainer(): void
    {
        $this->compile();

        self::assertInstanceOf(FrozenParameterBag::class, $this->container->getParameterBag());
    }
}
