<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueConverter;

use eZ\Publish\Core\Repository\Values\Content\Location as EzLocation;
use Netgen\BlockManager\Item\ValueConverterInterface;
use Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\ContentInfo;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\Location;
use Netgen\EzPlatformSiteApi\API\LoadService;
use PHPUnit\Framework\TestCase;

final class LocationValueConverterTest extends TestCase
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
     * @var \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter
     */
    private $valueConverter;

    public function setUp(): void
    {
        $this->innerConverterMock = $this->createMock(ValueConverterInterface::class);
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueConverter = new LocationValueConverter(
            $this->innerConverterMock,
            $this->loadServiceMock
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::supports
     */
    public function testSupports(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('supports');

        self::assertTrue($this->valueConverter->supports(new Location()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::supports
     */
    public function testSupportsWithoutSiteAPILocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('supports')
            ->with(self::identicalTo($location))
            ->will(self::returnValue(true));

        self::assertTrue($this->valueConverter->supports($location));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getValueType
     */
    public function testGetValueType(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getValueType');

        self::assertSame(
            'ezlocation',
            $this->valueConverter->getValueType(
                new Location()
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getId
     */
    public function testGetId(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getId');

        self::assertSame(
            24,
            $this->valueConverter->getId(
                new Location(['id' => 24])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getId
     */
    public function testGetIdWithoutSiteAPILocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getId')
            ->with(self::identicalTo($location))
            ->will(self::returnValue(42));

        self::assertSame(42, $this->valueConverter->getId($location));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getRemoteId
     */
    public function testGetRemoteId(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getRemoteId');

        self::assertSame(
            'abc',
            $this->valueConverter->getRemoteId(
                new Location(['remoteId' => 'abc'])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getRemoteId
     */
    public function testGetRemoteIdWithoutSiteAPILocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getRemoteId')
            ->with(self::identicalTo($location))
            ->will(self::returnValue('abc'));

        self::assertSame('abc', $this->valueConverter->getRemoteId($location));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getName
     */
    public function testGetName(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getName');

        self::assertSame(
            'Cool name',
            $this->valueConverter->getName(
                new Location(['contentInfo' => new ContentInfo(['name' => 'Cool name'])])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getName
     */
    public function testGetNameWithoutSiteAPILocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getName')
            ->with(self::identicalTo($location))
            ->will(self::returnValue('Cool name'));

        self::assertSame('Cool name', $this->valueConverter->getName($location));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getIsVisible
     */
    public function testGetIsVisible(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getIsVisible');

        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new Location(['invisible' => false])
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getIsVisible
     */
    public function testGetIsVisibleWithoutSiteAPILocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getIsVisible')
            ->with(self::identicalTo($location))
            ->will(self::returnValue(true));

        self::assertTrue($this->valueConverter->getIsVisible($location));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getObject
     */
    public function testGetObject(): void
    {
        $this->loadServiceMock
            ->expects(self::never())
            ->method('loadLocation');

        $object = new Location(['id' => 42]);

        self::assertSame($object, $this->valueConverter->getObject($object));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getObject
     */
    public function testGetObjectWithoutSiteAPILocation(): void
    {
        $location = new Location();

        $this->loadServiceMock
            ->expects(self::once())
            ->method('loadLocation')
            ->with(self::identicalTo(42))
            ->will(self::returnValue($location));

        self::assertSame($location, $this->valueConverter->getObject(new EzLocation(['id' => 42])));
    }
}
