<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\Configuration::__construct
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testDefaultAdapterSettings(): void
    {
        $config = [];

        $expectedConfig = [
            'search_service_adapter' => null,
        ];

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testNullAdapterSettings(): void
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
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testFilterAdapterSettings(): void
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
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testFindAdapterSettings(): void
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
     * @covers \Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testUnknownAdapterSettings(): void
    {
        $config = [
            [
                'search_service_adapter' => 'other',
            ],
        ];

        $this->assertConfigurationIsInvalid([$config]);
    }

    protected function getConfiguration(): ConfigurationInterface
    {
        $extensionMock = $this->createMock(ExtensionInterface::class);
        $extensionMock
            ->expects(self::any())
            ->method('getAlias')
            ->willReturn('alias');

        return new Configuration($extensionMock);
    }
}
