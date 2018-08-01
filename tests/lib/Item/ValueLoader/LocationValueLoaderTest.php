<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueLoader;

use Exception;
use Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\ContentInfo;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\Location;
use Netgen\EzPlatformSiteApi\API\LoadService;
use PHPUnit\Framework\TestCase;

final class LocationValueLoaderTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $loadServiceMock;

    /**
     * @var \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader
     */
    private $valueLoader;

    public function setUp(): void
    {
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueLoader = new LocationValueLoader($this->loadServiceMock);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::load
     */
    public function testLoad(): void
    {
        $location = new Location(
            [
                'id' => 52,
                'contentInfo' => new ContentInfo(
                    [
                        'published' => true,
                    ]
                ),
            ]
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocation')
            ->with($this->identicalTo(52))
            ->will($this->returnValue($location));

        $this->assertSame($location, $this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::load
     */
    public function testLoadWithNoLocation(): void
    {
        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocation')
            ->with($this->identicalTo(52))
            ->will($this->throwException(new Exception()));

        $this->assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::load
     */
    public function testLoadWithNonPublishedContent(): void
    {
        $location = new Location(
            [
                'contentInfo' => new ContentInfo(
                    [
                        'published' => false,
                    ]
                ),
            ]
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocation')
            ->with($this->identicalTo(52))
            ->will($this->returnValue($location));

        $this->assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteId(): void
    {
        $location = new Location(
            [
                'remoteId' => 'abc',
                'contentInfo' => new ContentInfo(
                    [
                        'published' => true,
                    ]
                ),
            ]
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocationByRemoteId')
            ->with($this->identicalTo('abc'))
            ->will($this->returnValue($location));

        $this->assertSame($location, $this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoLocation(): void
    {
        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocationByRemoteId')
            ->with($this->identicalTo('abc'))
            ->will($this->throwException(new Exception()));

        $this->assertNull($this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNonPublishedContent(): void
    {
        $location = new Location(
            [
                'contentInfo' => new ContentInfo(
                    [
                        'published' => false,
                    ]
                ),
            ]
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocationByRemoteId')
            ->with($this->identicalTo('abc'))
            ->will($this->returnValue($location));

        $this->assertNull($this->valueLoader->loadByRemoteId('abc'));
    }
}
