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
            ->expects($this->never())
            ->method('supports');

        $this->assertTrue($this->valueConverter->supports(new ContentInfo()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::supports
     */
    public function testSupportsWithoutSiteAPIContentInfo(): void
    {
        $this->innerConverterMock
            ->expects($this->once())
            ->method('supports')
            ->with($this->equalTo(new EzContentInfo()))
            ->will($this->returnValue(true));

        $this->assertTrue($this->valueConverter->supports(new EzContentInfo()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getValueType
     */
    public function testGetValueType(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getValueType');

        $this->assertSame(
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
            ->expects($this->never())
            ->method('getId');

        $this->assertSame(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getId')
            ->with($this->equalTo(new EzContentInfo()))
            ->will($this->returnValue(42));

        $this->assertSame(42, $this->valueConverter->getId(new EzContentInfo()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getRemoteId
     */
    public function testGetRemoteId(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getRemoteId');

        $this->assertSame(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getRemoteId')
            ->with($this->equalTo(new EzContentInfo()))
            ->will($this->returnValue('abc'));

        $this->assertSame('abc', $this->valueConverter->getRemoteId(new EzContentInfo()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getName
     */
    public function testGetName(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getName');

        $this->assertSame(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getName')
            ->with($this->equalTo(new EzContentInfo()))
            ->will($this->returnValue('Cool name'));

        $this->assertSame('Cool name', $this->valueConverter->getName(new EzContentInfo()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getIsVisible
     */
    public function testGetIsVisible(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getIsVisible');

        $this->assertTrue(
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
            ->expects($this->never())
            ->method('getIsVisible');

        $this->assertFalse(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getIsVisible')
            ->with($this->equalTo(new EzContentInfo()))
            ->will($this->returnValue(true));

        $this->assertTrue($this->valueConverter->getIsVisible(new EzContentInfo()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getObject
     */
    public function testGetObject(): void
    {
        $this->loadServiceMock
            ->expects($this->never())
            ->method('loadContent');

        $object = new ContentInfo(['id' => 42]);

        $this->assertSame($object, $this->valueConverter->getObject($object));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\ContentValueConverter::getObject
     */
    public function testGetObjectWithoutSiteAPIContentInfo(): void
    {
        $contentInfo = new ContentInfo(['id' => 42]);
        $object = new Content(['contentInfo' => $contentInfo]);

        $this->loadServiceMock
            ->expects($this->once())
            ->method('loadContent')
            ->with($this->equalTo(42))
            ->will($this->returnValue($object));

        $this->assertSame($contentInfo, $this->valueConverter->getObject(new Content(['id' => 42])));
    }
}
