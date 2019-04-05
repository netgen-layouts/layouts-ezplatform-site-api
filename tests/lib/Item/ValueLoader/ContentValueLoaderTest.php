<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueLoader;

use Exception;
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
            ->expects(self::any())
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willReturn($content);

        self::assertSame($contentInfo, $this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoadWithNoContent(): void
    {
        $this->loadServiceMock
            ->expects(self::any())
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoadWithNonPublishedContent(): void
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
            ->expects(self::any())
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willReturn($content);

        self::assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoadWithNoMainLocation(): void
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
            ->expects(self::any())
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willReturn($content);

        self::assertNull($this->valueLoader->load(52));
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
            ->expects(self::any())
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($content);

        self::assertSame($contentInfo, $this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoContent(): void
    {
        $this->loadServiceMock
            ->expects(self::any())
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNonPublishedContent(): void
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
            ->expects(self::any())
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($content);

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoMainLocation(): void
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
            ->expects(self::any())
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($content);

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }
}
