<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Item\ValueUrlGenerator;

use eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\Location;
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
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator\LocationValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $location = new Location(
            [
                'id' => 42,
            ]
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo(UrlAliasRouter::URL_ALIAS_ROUTE_NAME),
                self::identicalTo(['locationId' => 42])
            )
            ->willReturn('/location/path');

        self::assertSame('/location/path', $this->urlGenerator->generate($location));
    }
}
