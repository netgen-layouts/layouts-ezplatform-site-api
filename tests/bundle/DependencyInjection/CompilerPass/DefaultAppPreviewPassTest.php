<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\Tests\DependencyInjection\CompilerPass;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultAppPreviewPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

final class DefaultAppPreviewPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultAppPreviewPass::addDefaultPreviewRule
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultAppPreviewPass::process
     */
    public function testProcess(): void
    {
        $this->container->setParameter('ezpublish.siteaccess.list', ['cro']);
        $this->container->setParameter(
            'netgen_layouts.app.ezplatform.item_preview_template',
            'default.html.twig'
        );

        $this->container->setParameter(
            'ezsettings.default.ngcontent_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
            ]
        );

        $this->container->setParameter(
            'ezsettings.cro.ngcontent_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
                'nglayouts_app_preview' => [
                    'article' => [
                        'template' => 'nglayouts_article.html.twig',
                    ],
                ],
            ]
        );

        $this->compile();

        $this->assertContainerBuilderHasParameter(
            'ezsettings.default.ngcontent_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
                'nglayouts_app_preview' => [
                    '___nglayouts_app_preview_default___' => [
                        'template' => 'default.html.twig',
                        'match' => [],
                        'params' => [],
                    ],
                ],
            ]
        );

        $this->assertContainerBuilderHasParameter(
            'ezsettings.cro.ngcontent_view',
            [
                'full' => [
                    'article' => [
                        'template' => 'article.html.twig',
                    ],
                ],
                'nglayouts_app_preview' => [
                    'article' => [
                        'template' => 'nglayouts_article.html.twig',
                    ],
                    '___nglayouts_app_preview_default___' => [
                        'template' => 'default.html.twig',
                        'match' => [],
                        'params' => [],
                    ],
                ],
            ]
        );

        self::assertFalse($this->container->hasParameter('netgen_layouts.default.ngcontent_view'));
        self::assertFalse($this->container->hasParameter('netgen_layouts.cro.ngcontent_view'));
    }

    /**
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultAppPreviewPass::process
     */
    public function testProcessWithEmptyContainer(): void
    {
        $this->compile();

        self::assertInstanceOf(FrozenParameterBag::class, $this->container->getParameterBag());
    }

    /**
     * Register the compiler pass under test.
     */
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DefaultAppPreviewPass());
    }
}
