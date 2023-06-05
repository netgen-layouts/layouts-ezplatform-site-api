<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Item\ValueLoader;

use Exception;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\Content;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\ContentInfo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ContentValueLoaderTest extends TestCase
{
    private MockObject $loadServiceMock;

    private ContentValueLoader $valueLoader;

    protected function setUp(): void
    {
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueLoader = new ContentValueLoader($this->loadServiceMock);
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::__construct
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoad(): void
    {
        $contentInfo = new ContentInfo(
            [
                'id' => 52,
                'published' => true,
                'mainLocationId' => 42,
            ],
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ],
        );

        $this->loadServiceMock
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willReturn($content);

        self::assertSame($contentInfo, $this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoadWithNoContent(): void
    {
        $this->loadServiceMock
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoadWithNonPublishedContent(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => false,
                'mainLocationId' => 42,
            ],
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ],
        );

        $this->loadServiceMock
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willReturn($content);

        self::assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::load
     */
    public function testLoadWithNoMainLocation(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => true,
                'mainLocationId' => null,
            ],
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ],
        );

        $this->loadServiceMock
            ->method('loadContent')
            ->with(self::identicalTo(52))
            ->willReturn($content);

        self::assertNull($this->valueLoader->load(52));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteId(): void
    {
        $contentInfo = new ContentInfo(
            [
                'remoteId' => 'abc',
                'published' => true,
                'mainLocationId' => 42,
            ],
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ],
        );

        $this->loadServiceMock
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($content);

        self::assertSame($contentInfo, $this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoContent(): void
    {
        $this->loadServiceMock
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNonPublishedContent(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => false,
                'mainLocationId' => 42,
            ],
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ],
        );

        $this->loadServiceMock
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($content);

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueLoader\ContentValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoMainLocation(): void
    {
        $contentInfo = new ContentInfo(
            [
                'published' => true,
                'mainLocationId' => null,
            ],
        );

        $content = new Content(
            [
                'contentInfo' => $contentInfo,
            ],
        );

        $this->loadServiceMock
            ->method('loadContentByRemoteId')
            ->with(self::identicalTo('abc'))
            ->willReturn($content);

        self::assertNull($this->valueLoader->loadByRemoteId('abc'));
    }
}
