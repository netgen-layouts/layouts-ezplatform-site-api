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
            ->expects($this->never())
            ->method('supports');

        $this->assertTrue($this->valueConverter->supports(new Location()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::supports
     */
    public function testSupportsWithoutSiteAPILocation(): void
    {
        $this->innerConverterMock
            ->expects($this->once())
            ->method('supports')
            ->with($this->equalTo(new EzLocation()))
            ->will($this->returnValue(true));

        $this->assertTrue($this->valueConverter->supports(new EzLocation()));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getValueType
     */
    public function testGetValueType(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getValueType');

        $this->assertSame(
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
            ->expects($this->never())
            ->method('getId');

        $this->assertSame(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getId')
            ->with($this->equalTo(new EzLocation()))
            ->will($this->returnValue(42));

        $this->assertSame(
            42,
            $this->valueConverter->getId(
                new EzLocation()
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getRemoteId
     */
    public function testGetRemoteId(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getRemoteId');

        $this->assertSame(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getRemoteId')
            ->with($this->equalTo(new EzLocation()))
            ->will($this->returnValue('abc'));

        $this->assertSame(
            'abc',
            $this->valueConverter->getRemoteId(
                new EzLocation()
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getName
     */
    public function testGetName(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getName');

        $this->assertSame(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getName')
            ->with($this->equalTo(new EzLocation()))
            ->will($this->returnValue('Cool name'));

        $this->assertSame(
            'Cool name',
            $this->valueConverter->getName(
                new EzLocation()
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getIsVisible
     */
    public function testGetIsVisible(): void
    {
        $this->innerConverterMock
            ->expects($this->never())
            ->method('getIsVisible');

        $this->assertTrue(
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
        $this->innerConverterMock
            ->expects($this->once())
            ->method('getIsVisible')
            ->with($this->equalTo(new EzLocation()))
            ->will($this->returnValue(true));

        $this->assertTrue(
            $this->valueConverter->getIsVisible(
                new EzLocation()
            )
        );
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getObject
     */
    public function testGetObject(): void
    {
        $this->loadServiceMock
            ->expects($this->never())
            ->method('loadLocation');

        $object = new Location(['id' => 42]);

        $this->assertSame($object, $this->valueConverter->getObject($object));
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueConverter\LocationValueConverter::getObject
     */
    public function testGetObjectWithoutSiteAPILocation(): void
    {
        $location = new Location();

        $this->loadServiceMock
            ->expects($this->once())
            ->method('loadLocation')
            ->with($this->equalTo(42))
            ->will($this->returnValue($location));

        $this->assertSame($location, $this->valueConverter->getObject(new EzLocation(['id' => 42])));
    }
}
