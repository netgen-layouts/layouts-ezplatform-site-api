<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteAPIBlockManagerBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testDefaultAdapterSettings(): void
    {
        $config = [];

        $expectedConfig = [
            'search_service_adapter' => null,
        ];

        self::assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
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

        self::assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
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

        self::assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
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

        self::assertProcessedConfigurationEquals($config, $expectedConfig);
    }

    /**
     * @covers \Netgen\Bundle\SiteAPIBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testUnknownAdapterSettings(): void
    {
        $config = [
            [
                'search_service_adapter' => 'other',
            ],
        ];

        self::assertConfigurationIsInvalid([$config]);
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
