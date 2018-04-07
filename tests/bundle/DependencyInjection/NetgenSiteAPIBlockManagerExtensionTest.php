<?php

namespace Netgen\Bundle\SiteAPIBlockManagerBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Netgen\Bundle\BlockManagerBundle\DependencyInjection\NetgenBlockManagerExtension;
use Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\NetgenSiteAPIBlockManagerExtension;

final class NetgenSiteAPIBlockManagerExtensionTest extends AbstractExtensionTestCase
{
    /**
     * We test for existence of one service from each of the config files.
     *
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\NetgenSiteAPIBlockManagerExtension::load
     */
    public function testServices()
    {
        $this->load();

        $this->assertContainerBuilderHasService(
            'netgen_block_manager.site_api.item.value_converter.ezlocation'
        );

        $this->assertContainerBuilderHasParameter(
            'netgen_block_manager.app.ezpublish.item_preview_template',
            '@NetgenSiteAPIBlockManager/api/item/ngbm_app_preview.html.twig'
        );

        $this->assertContainerBuilderHasParameter(
            'netgen_block_manager.site_api.search_service_adapter',
            null
        );
    }

    /**
     * We test for existence of one config value from each of the config files.
     *
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\NetgenSiteAPIBlockManagerExtension::prepend
     */
    public function testPrepend()
    {
        $this->container->setParameter('kernel.bundles', array('NetgenBlockManagerBundle' => true));
        $this->container->registerExtension(new NetgenBlockManagerExtension());

        $extension = $this->container->getExtension('netgen_site_api_block_manager');
        $extension->prepend($this->container);

        $config = array_merge_recursive(
            ...$this->container->getExtensionConfig('netgen_block_manager')
        );

        $this->assertInternalType('array', $config);

        $this->assertArrayHasKey('view', $config);
        $this->assertArrayHasKey('item_view', $config['view']);
        $this->assertArrayHasKey('api', $config['view']['item_view']);

        $this->assertArrayHasKey('ezcontent\siteapi', $config['view']['item_view']['api']);
        $this->assertArrayHasKey('ezlocation\siteapi', $config['view']['item_view']['api']);
    }

    protected function getContainerExtensions()
    {
        return array(new NetgenSiteAPIBlockManagerExtension());
    }
}
