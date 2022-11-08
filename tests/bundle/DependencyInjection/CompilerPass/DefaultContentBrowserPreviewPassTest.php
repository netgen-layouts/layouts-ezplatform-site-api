<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\Tests\DependencyInjection\CompilerPass;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

final class DefaultContentBrowserPreviewPassTest extends AbstractContainerBuilderTestCase
{
    /**
     * Register the compiler pass under test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->container->addCompilerPass(new DefaultContentBrowserPreviewPass());
    }

    /**
     * @covers \Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass::addDefaultPreviewRule
     * @covers \Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass::process
     */
    public function testProcess(): void
    {
        $this->container->setParameter('ibexa.site_access.list', ['cro']);
        $this->container->setParameter(
            'netgen_content_browser.ibexa.preview_template',
            'default.html.twig',
        );

        $this->container->setParameter(
            'ibexa.site_access.config.default.ng_content_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
            ],
        );

        $this->container->setParameter(
            'ibexa.site_access.config.cro.ng_content_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
                'ngcb_preview' => [
                    'article' => [
                        'template' => 'ngcb_article.html.twig',
                    ],
                ],
            ],
        );

        $this->compile();

        $this->assertContainerBuilderHasParameter(
            'ibexa.site_access.config.default.ng_content_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
                'ngcb_preview' => [
                    '___ngcb_preview_default___' => [
                        'template' => 'default.html.twig',
                        'match' => [],
                        'params' => [],
                    ],
                ],
            ],
        );

        $this->assertContainerBuilderHasParameter(
            'ibexa.site_access.config.cro.ng_content_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
                'ngcb_preview' => [
                    'article' => [
                        'template' => 'ngcb_article.html.twig',
                    ],
                    '___ngcb_preview_default___' => [
                        'template' => 'default.html.twig',
                        'match' => [],
                        'params' => [],
                    ],
                ],
            ],
        );
    }

    /**
     * @covers \Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass::process
     */
    public function testProcessWithEmptyContainer(): void
    {
        $this->compile();

        self::assertInstanceOf(FrozenParameterBag::class, $this->container->getParameterBag());
    }
}
