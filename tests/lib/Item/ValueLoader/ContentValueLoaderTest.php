<?php

declare(strict_types=1);

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

    public function setUp(): void
    {
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueLoader = new ContentValueLoader($this->loadServiceMock);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoad(): void
    {
        $contentInfo = new ContentInfo(
            [
                'id' => 52,
                'published' => true,
                'mainLocationId' => 42,
            ]
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ]
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContent')
            ->with($this->isType('int'))
            ->will($this->returnValue($content));

        $this->assertSame($contentInfo, $this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with ID "52" could not be loaded.
     */
    public function testLoadThrowsItemException(): void
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
    public function testLoadThrowsItemExceptionWithNonPublishedContent(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => false,
                'mainLocationId' => 42,
            ]
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ]
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
    public function testLoadThrowsItemExceptionWithNoMainLocation(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => true,
            ]
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ]
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
    public function testLoadByRemoteId(): void
    {
        $contentInfo = new ContentInfo(
            [
                'remoteId' => 'abc',
                'published' => true,
                'mainLocationId' => 42,
            ]
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ]
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContentByRemoteId')
            ->with($this->isType('string'))
            ->will($this->returnValue($content));

        $this->assertSame($contentInfo, $this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     * @expectedException \Netgen\BlockManager\Exception\Item\ItemException
     * @expectedExceptionMessage Content with remote ID "abc" could not be loaded.
     */
    public function testLoadByRemoteIdThrowsItemException(): void
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
    public function testLoadByRemoteIdThrowsItemExceptionWithNonPublishedContent(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => false,
                'mainLocationId' => 42,
            ]
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ]
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
    public function testLoadByRemoteIdThrowsItemExceptionWithNoMainLocation(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => true,
            ]
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ]
        );

        $this->loadServiceMock
            ->expects($this->any())
            ->method('loadContentByRemoteId')
            ->with($this->isType('string'))
            ->will($this->returnValue($content));

        $this->valueLoader->loadByRemoteId('abc');
    }
}
