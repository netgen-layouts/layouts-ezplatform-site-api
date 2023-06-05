<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

#[CoversClass(Configuration::class)]
final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    public function testDefaultAdapterSettings(): void
    {
        $config = [];

        $expectedConfig = [
            'search_service_adapter' => null,
        ];

        $this->assertProcessedConfigurationEquals($config, $expectedConfig);
    }

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
            ->method('getAlias')
            ->willReturn('alias');

        return new Configuration($extensionMock);
    }
}
