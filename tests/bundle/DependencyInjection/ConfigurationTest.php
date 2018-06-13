<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteAPIBlockManagerBundle\Tests\DependencyInjection;

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
        $config = [];

        $expectedConfig = [
            'search_service_adapter' => null,
        ];

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testNullAdapterSettings()
    {
        $config = [
            [
                'search_service_adapter' => null,
            ],
        ];

        $expectedConfig = [
            'search_service_adapter' => null,
        ];

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testFilterAdapterSettings()
    {
        $config = [
            [
                'search_service_adapter' => 'filter',
            ],
        ];

        $expectedConfig = [
            'search_service_adapter' => 'filter',
        ];

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testFindAdapterSettings()
    {
        $config = [
            [
                'search_service_adapter' => 'find',
            ],
        ];

        $expectedConfig = [
            'search_service_adapter' => 'find',
        ];

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testUnknownAdapterSettings()
    {
        $config = [
            [
                'search_service_adapter' => 'other',
            ],
        ];

        $this->assertConfigurationIsInvalid([$config]);
    }

    protected function getConfiguration()
    {
        return new Configuration();
    }
}
