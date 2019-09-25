<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\Tests\DependencyInjection\CompilerPass;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

final class DefaultContentBrowserPreviewPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass::addDefaultPreviewRule
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass::process
     */
    public function testProcess(): void
    {
        $this->container->setParameter('ezpublish.siteaccess.list', ['cro']);
        $this->container->setParameter(
            'netgen_content_browser.ezplatform.preview_template',
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
                'ngcb_preview' => [
                    'article' => [
                        'template' => 'ngcb_article.html.twig',
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
                'ngcb_preview' => [
                    '___ngcb_preview_default___' => [
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
            ]
        );
    }

    /**
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass\DefaultContentBrowserPreviewPass::process
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
        $container->addCompilerPass(new DefaultContentBrowserPreviewPass());
    }
}
