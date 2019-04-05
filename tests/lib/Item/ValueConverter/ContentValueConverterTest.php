<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueConverter;

use eZ\Publish\API\Repository\Values\Content\ContentInfo as EzContentInfo;
use Netgen\BlockManager\Item\ValueConverterInterface;
use Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\Content;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\ContentInfo;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\Location;
use Netgen\EzPlatformSiteApi\API\LoadService;
use PHPUnit\Framework\TestCase;

final class ContentValueConverterTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $innerConverterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $loadServiceMock;

    /**
     * @var \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter
     */
    private $valueConverter;

    public function setUp(): void
    {
        $this->innerConverterMock = $this->createMock(ValueConverterInterface::class);
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueConverter = new ContentValueConverter(
            $this->innerConverterMock,
            $this->loadServiceMock
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::supports
     */
    public function testSupports(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('supports');

        self::assertTrue($this->valueConverter->supports(new ContentInfo()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::supports
     */
    public function testSupportsWithoutSiteAPIContentInfo(): void
    {
        $contentInfo = new EzContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('supports')
            ->with(self::identicalTo($contentInfo))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->supports($contentInfo));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getValueType
     */
    public function testGetValueType(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getValueType');

        self::assertSame(
            'ezcontent',
            $this->valueConverter->getValueType(
                new ContentInfo()
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getId
     */
    public function testGetId(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getId');

        self::assertSame(
            24,
            $this->valueConverter->getId(
                new ContentInfo(['id' => 24])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getId
     */
    public function testGetIdWithoutSiteAPIContentInfo(): void
    {
        $contentInfo = new EzContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getId')
            ->with(self::identicalTo($contentInfo))
            ->willReturn(42);

        self::assertSame(42, $this->valueConverter->getId($contentInfo));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getRemoteId
     */
    public function testGetRemoteId(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getRemoteId');

        self::assertSame(
            'abc',
            $this->valueConverter->getRemoteId(
                new ContentInfo(['remoteId' => 'abc'])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getRemoteId
     */
    public function testGetRemoteIdWithoutSiteAPIContentInfo(): void
    {
        $contentInfo = new EzContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getRemoteId')
            ->with(self::identicalTo($contentInfo))
            ->willReturn('abc');

        self::assertSame('abc', $this->valueConverter->getRemoteId($contentInfo));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getName
     */
    public function testGetName(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getName');

        self::assertSame(
            'Cool name',
            $this->valueConverter->getName(
                new ContentInfo(['name' => 'Cool name'])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getName
     */
    public function testGetNameWithoutSiteAPIContentInfo(): void
    {
        $contentInfo = new EzContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getName')
            ->with(self::identicalTo($contentInfo))
            ->willReturn('Cool name');

        self::assertSame('Cool name', $this->valueConverter->getName($contentInfo));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getIsVisible
     */
    public function testGetIsVisible(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getIsVisible');

        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new ContentInfo(['mainLocation' => new Location(['invisible' => false])])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getIsVisible
     */
    public function testGetIsVisibleWithoutMainLocation(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getIsVisible');

        self::assertFalse(
            $this->valueConverter->getIsVisible(
                new ContentInfo()
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getIsVisible
     */
    public function testGetIsVisibleWithoutSiteAPIContentInfo(): void
    {
        $contentInfo = new EzContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getIsVisible')
            ->with(self::identicalTo($contentInfo))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->getIsVisible($contentInfo));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getObject
     */
    public function testGetObject(): void
    {
        $this->loadServiceMock
            ->expects(self::never())
            ->method('loadContent');

        $object = new ContentInfo(['id' => 42]);

        self::assertSame($object, $this->valueConverter->getObject($object));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getObject
     */
    public function testGetObjectWithoutSiteAPIContentInfo(): void
    {
        $contentInfo = new ContentInfo();
        $content = new Content(['contentInfo' => $contentInfo]);

        $this->loadServiceMock
            ->expects(self::once())
            ->method('loadContent')
            ->with(self::identicalTo(42))
            ->willReturn($content);

        self::assertSame($contentInfo, $this->valueConverter->getObject(new EzContentInfo(['id' => 42])));
    }
}
