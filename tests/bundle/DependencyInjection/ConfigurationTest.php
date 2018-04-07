<?php

namespace Netgen\Bundle\SiteAPIBlockManagerBundle\Tests\DependencyInjection\ConfigurationNode;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testDefaultAdapterSettings()
    {
        $config = array();

        $expectedConfig = array(
            'search_service_adapter' => null,
        );

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testNullAdapterSettings()
    {
        $config = array(
            array(
                'search_service_adapter' => null,
            ),
        );

        $expectedConfig = array(
            'search_service_adapter' => null,
        );

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testFilterAdapterSettings()
    {
        $config = array(
            array(
                'search_service_adapter' => 'filter',
            ),
        );

        $expectedConfig = array(
            'search_service_adapter' => 'filter',
        );

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testFindAdapterSettings()
    {
        $config = array(
            array(
                'search_service_adapter' => 'find',
            ),
        );

        $expectedConfig = array(
            'search_service_adapter' => 'find',
        );

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testUnknownAdapterSettings()
    {
        $config = array(
            array(
                'search_service_adapter' => 'other',
            ),
        );

        $this->assertConfigurationIsInvalid(array($config));
    }

    protected function getConfiguration()
    {
        return new Configuration();
    }
}
