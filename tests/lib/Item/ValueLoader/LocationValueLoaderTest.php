<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Item\ValueLoader;

use Exception;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\ContentInfo;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\Location;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LocationValueLoaderTest extends TestCase
{
    private MockObject $loadServiceMock;

    private LocationValueLoader $valueLoader;

    protected function setUp(): void
    {
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueLoader = new LocationValueLoader($this->loadServiceMock);
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader::__construct
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader::load
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
            ->expects(self::any())
            ->method('loadLocation')
            ->with(self::identicalTo(52))
            ->willReturn($location);

        self::assertSame($location, $this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader::load
     */
    public function testLoadWithNoLocation(): void
    {
        $this->loadServiceMock
            ->expects(self::any())
            ->method('loadLocation')
            ->with(self::identicalTo(52))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader::load
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
            ->expects(self::any())
            ->method('loadLocation')
            ->with(self::identicalTo(52))
            ->willReturn($location);

        self::assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader::loadByRemoteId
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
            ->expects(self::any())
            ->method('loadLocationByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($location);

        self::assertSame($location, $this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoLocation(): void
    {
        $this->loadServiceMock
            ->expects(self::any())
            ->method('loadLocationByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\LocationValueLoader::loadByRemoteId
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
            ->expects(self::any())
            ->method('loadLocationByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($location);

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }
}
