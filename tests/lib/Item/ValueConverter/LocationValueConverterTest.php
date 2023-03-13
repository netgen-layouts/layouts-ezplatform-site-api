<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Tests\Item\ValueConverter;

use Ibexa\Core\Repository\Values\Content\Location as IbexaLocation;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\Layouts\Ibexa\SiteApi\Item\ValueConverter\LocationValueConverter;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\ContentInfo;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\Location;
use Netgen\Layouts\Item\ValueConverterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationValueConverter::class)]
final class LocationValueConverterTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject&\Netgen\Layouts\Item\ValueConverterInterface<\Netgen\IbexaSiteApi\API\Values\Location>
     */
    private MockObject&ValueConverterInterface $innerConverterMock;

    private MockObject&LoadService $loadServiceMock;

    private LocationValueConverter $valueConverter;

    protected function setUp(): void
    {
        $this->innerConverterMock = $this->createMock(ValueConverterInterface::class);
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueConverter = new LocationValueConverter(
            $this->innerConverterMock,
            $this->loadServiceMock,
        );
    }

    public function testSupports(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('supports');

        self::assertTrue($this->valueConverter->supports(new Location()));
    }

    public function testSupportsWithoutSiteApiLocation(): void
    {
        $location = new IbexaLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('supports')
            ->with(self::identicalTo($location))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->supports($location));
    }

    public function testGetValueType(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getValueType');

        self::assertSame(
            'ibexa_location',
            $this->valueConverter->getValueType(
                new Location(),
            ),
        );
    }

    public function testGetId(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getId');

        self::assertSame(
            24,
            $this->valueConverter->getId(
                new Location(['id' => 24]),
            ),
        );
    }

    public function testGetIdWithoutSiteApiLocation(): void
    {
        $location = new IbexaLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getId')
            ->with(self::identicalTo($location))
            ->willReturn(42);

        self::assertSame(42, $this->valueConverter->getId($location));
    }

    public function testGetRemoteId(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getRemoteId');

        self::assertSame(
            'abc',
            $this->valueConverter->getRemoteId(
                new Location(['remoteId' => 'abc']),
            ),
        );
    }

    public function testGetRemoteIdWithoutSiteApiLocation(): void
    {
        $location = new IbexaLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getRemoteId')
            ->with(self::identicalTo($location))
            ->willReturn('abc');

        self::assertSame('abc', $this->valueConverter->getRemoteId($location));
    }

    public function testGetName(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getName');

        self::assertSame(
            'Cool name',
            $this->valueConverter->getName(
                new Location(['contentInfo' => new ContentInfo(['name' => 'Cool name'])]),
            ),
        );
    }

    public function testGetNameWithoutSiteApiLocation(): void
    {
        $location = new IbexaLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getName')
            ->with(self::identicalTo($location))
            ->willReturn('Cool name');

        self::assertSame('Cool name', $this->valueConverter->getName($location));
    }

    public function testGetIsVisible(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getIsVisible');

        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new Location(['invisible' => false]),
            ),
        );
    }

    public function testGetIsVisibleWithoutSiteApiLocation(): void
    {
        $location = new IbexaLocation();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getIsVisible')
            ->with(self::identicalTo($location))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->getIsVisible($location));
    }

    public function testGetObject(): void
    {
        $this->loadServiceMock
            ->expects(self::never())
            ->method('loadLocation');

        $object = new Location(['id' => 42]);

        self::assertSame($object, $this->valueConverter->getObject($object));
    }

    public function testGetObjectWithoutSiteApiLocation(): void
    {
        $location = new Location();

        $this->loadServiceMock
            ->expects(self::once())
            ->method('loadLocation')
            ->with(self::identicalTo(42))
            ->willReturn($location);

        self::assertSame($location, $this->valueConverter->getObject(new IbexaLocation(['id' => 42])));
    }
}
