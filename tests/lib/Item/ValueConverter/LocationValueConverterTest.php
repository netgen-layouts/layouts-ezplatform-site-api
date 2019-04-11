<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Item\ValueConverter;

use eZ\Publish\Core\Repository\Values\Content\Location as EzLocation;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\ContentInfo;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\Location;
use Netgen\Layouts\Item\ValueConverterInterface;
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
     * @var \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::__construct
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::supports
     */
    public function testSupports(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('supports');

        self::assertTrue($this->valueConverter->supports(new Location()));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::supports
     */
    public function testSupportsWithoutSiteApiLocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('supports')
            ->with(self::identicalTo($location))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->supports($location));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getValueType
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getId
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getId
     */
    public function testGetIdWithoutSiteApiLocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getId')
            ->with(self::identicalTo($location))
            ->willReturn(42);

        self::assertSame(42, $this->valueConverter->getId($location));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getRemoteId
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getRemoteId
     */
    public function testGetRemoteIdWithoutSiteApiLocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getRemoteId')
            ->with(self::identicalTo($location))
            ->willReturn('abc');

        self::assertSame('abc', $this->valueConverter->getRemoteId($location));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getName
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getName
     */
    public function testGetNameWithoutSiteApiLocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getName')
            ->with(self::identicalTo($location))
            ->willReturn('Cool name');

        self::assertSame('Cool name', $this->valueConverter->getName($location));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getIsVisible
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getIsVisible
     */
    public function testGetIsVisibleWithoutSiteApiLocation(): void
    {
        $location = new EzLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getIsVisible')
            ->with(self::identicalTo($location))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->getIsVisible($location));
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getObject
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueConverter\LocationValueConverter::getObject
     */
    public function testGetObjectWithoutSiteApiLocation(): void
    {
        $location = new Location();

        $this->loadServiceMock
            ->expects(self::once())
            ->method('loadLocation')
            ->with(self::identicalTo(42))
            ->willReturn($location);

        self::assertSame($location, $this->valueConverter->getObject(new EzLocation(['id' => 42])));
    }
}
