<?php

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueLoader;

use Netgen\BlockManager\Exception\Item\ItemException;
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

    public function setUp()
    {
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueLoader = new LocationValueLoader($this->loadServiceMock);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::load
     */
    public function testLoad()
    {
        $location = new Location(
            array(
                'id' => 52,
                'contentInfo' => new ContentInfo(
                    array(
                        'published' => true,
                    )
                ),
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocation')
            ->with($this->isType('int'))
            ->will($this->returnValue($location));

        $this->assertEquals($location, $this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::load
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Location with ID "52" could not be loaded.
     */
    public function testLoadThrowsItemException()
    {
        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocation')
            ->with($this->isType('int'))
            ->will($this->throwException(new ItemException()));

        $this->valueLoader->load(52);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::load
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Location with ID "52" has unpublished content and cannot be loaded.
     */
    public function testLoadThrowsItemExceptionWithNonPublishedContent()
    {
        $location = new Location(
            array(
                'contentInfo' => new ContentInfo(
                    array(
                        'published' => false,
                    )
                ),
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocation')
            ->with($this->isType('int'))
            ->will($this->returnValue($location));

        $this->valueLoader->load(52);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteId()
    {
        $location = new Location(
            array(
                'remoteId' => 'abc',
                'contentInfo' => new ContentInfo(
                    array(
                        'published' => true,
                    )
                ),
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocationByRemoteId')
            ->with($this->isType('string'))
            ->will($this->returnValue($location));

        $this->assertEquals($location, $this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::loadByRemoteId
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Location with remote ID "abc" could not be loaded.
     */
    public function testLoadByRemoteIdThrowsItemException()
    {
        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocationByRemoteId')
            ->with($this->isType('string'))
            ->will($this->throwException(new ItemException()));

        $this->valueLoader->loadByRemoteId('abc');
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\LocationValueLoader::loadByRemoteId
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Location with remote ID "abc" has unpublished content and cannot be loaded.
     */
    public function testLoadByRemoteIdThrowsItemExceptionWithNonPublishedContent()
    {
        $location = new Location(
            array(
                'contentInfo' => new ContentInfo(
                    array(
                        'published' => false,
                    )
                ),
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadLocationByRemoteId')
            ->with($this->isType('string'))
            ->will($this->returnValue($location));

        $this->valueLoader->loadByRemoteId('abc');
    }
}
