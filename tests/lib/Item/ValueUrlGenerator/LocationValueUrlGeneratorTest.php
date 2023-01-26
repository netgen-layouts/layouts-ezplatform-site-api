<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Tests\Item\ValueUrlGenerator;

use Ibexa\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\ContentInfo;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\Location;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class LocationValueUrlGeneratorTest extends TestCase
{
    private MockObject $urlGeneratorMock;

    private LocationValueUrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new LocationValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator::generateDefaultUrl
     */
    public function testGenerateDefaultUrl(): void
    {
        $location = new Location(
            [
                'id' => 42,
            ],
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo(UrlAliasRouter::URL_ALIAS_ROUTE_NAME),
                self::identicalTo(['locationId' => 42]),
            )
            ->willReturn('/location/path');

        self::assertSame('/location/path', $this->urlGenerator->generateDefaultUrl($location));
    }

    /**
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator::generateAdminUrl
     */
    public function testGenerateAdminUrl(): void
    {
        $location = new Location(
            [
                'id' => 42,
                'contentInfo' => new ContentInfo(['id' => 24]),
            ],
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo('ibexa.content.view'),
                self::identicalTo(['contentId' => 24, 'locationId' => 42]),
            )
            ->willReturn('/admin/location/path');

        self::assertSame('/admin/location/path', $this->urlGenerator->generateAdminUrl($location));
    }

    /**
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $location = new Location(
            [
                'id' => 42,
            ],
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo(UrlAliasRouter::URL_ALIAS_ROUTE_NAME),
                self::identicalTo(['locationId' => 42]),
            )
            ->willReturn('/location/path');

        self::assertSame('/location/path', $this->urlGenerator->generate($location));
    }
}
