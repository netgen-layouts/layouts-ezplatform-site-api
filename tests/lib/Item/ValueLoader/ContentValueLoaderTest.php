<?php

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueLoader;

use Netgen\BlockManager\Exception\Item\ItemException;
use Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\Content;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\ContentInfo;
use Netgen\EzPlatformSiteApi\API\LoadService;
use PHPUnit\Framework\TestCase;

final class ContentValueLoaderTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $loadServiceMock;

    /**
     * @var \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader
     */
    private $valueLoader;

    public function setUp()
    {
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueLoader = new ContentValueLoader($this->loadServiceMock);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoad()
    {
        $contentInfo = new ContentInfo(
            array(
                'id' => 52,
                'published' => true,
                'mainLocationId' => 42,
            )
        );

        $content = new Content(
            array(
                'contentInfo' => $contentInfo,
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContent')
            ->with($this->isType('int'))
            ->will($this->returnValue($content));

        $this->assertEquals($contentInfo, $this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with ID "52" could not be loaded.
     */
    public function testLoadThrowsItemException()
    {
        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContent')
            ->with($this->isType('int'))
            ->will($this->throwException(new ItemException()));

        $this->valueLoader->load(52);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with ID "52" is not published and cannot loaded.
     */
    public function testLoadThrowsItemExceptionWithNonPublishedContent()
    {
        $contentInfo = new ContentInfo(
            array(
                'published' => false,
                'mainLocationId' => 42,
            )
        );

        $content = new Content(
            array(
                'contentInfo' => $contentInfo,
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContent')
            ->with($this->isType('int'))
            ->will($this->returnValue($content));

        $this->valueLoader->load(52);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with ID "52" does not have a main location and cannot loaded.
     */
    public function testLoadThrowsItemExceptionWithNoMainLocation()
    {
        $contentInfo = new ContentInfo(
            array(
                'published' => true,
            )
        );

        $content = new Content(
            array(
                'contentInfo' => $contentInfo,
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContent')
            ->with($this->isType('int'))
            ->will($this->returnValue($content));

        $this->valueLoader->load(52);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteId()
    {
        $contentInfo = new ContentInfo(
            array(
                'remoteId' => 'abc',
                'published' => true,
                'mainLocationId' => 42,
            )
        );

        $content = new Content(
            array(
                'contentInfo' => $contentInfo,
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContentByRemoteId')
            ->with($this->isType('string'))
            ->will($this->returnValue($content));

        $this->assertEquals($contentInfo, $this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with remote ID "abc" could not be loaded.
     */
    public function testLoadByRemoteIdThrowsItemException()
    {
        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContentByRemoteId')
            ->with($this->isType('string'))
            ->will($this->throwException(new ItemException()));

        $this->valueLoader->loadByRemoteId('abc');
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with remote ID "abc" is not published and cannot loaded.
     */
    public function testLoadByRemoteIdThrowsItemExceptionWithNonPublishedContent()
    {
        $contentInfo = new ContentInfo(
            array(
                'published' => false,
                'mainLocationId' => 42,
            )
        );

        $content = new Content(
            array(
                'contentInfo' => $contentInfo,
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContentByRemoteId')
            ->with($this->isType('string'))
            ->will($this->returnValue($content));

        $this->valueLoader->loadByRemoteId('abc');
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with remote ID "abc" does not have a main location and cannot loaded.
     */
    public function testLoadByRemoteIdThrowsItemExceptionWithNoMainLocation()
    {
        $contentInfo = new ContentInfo(
            array(
                'published' => true,
            )
        );

        $content = new Content(
            array(
                'contentInfo' => $contentInfo,
            )
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContentByRemoteId')
            ->with($this->isType('string'))
            ->will($this->returnValue($content));

        $this->valueLoader->loadByRemoteId('abc');
    }
}
