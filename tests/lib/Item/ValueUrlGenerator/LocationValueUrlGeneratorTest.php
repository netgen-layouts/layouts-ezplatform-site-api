<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueUrlGenerator;

use eZ\Publish\Core\Repository\Values\Content\Location as EzLocation;
use Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\LocationValueUrlGenerator;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\Location;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class LocationValueUrlGeneratorTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $urlGeneratorMock;

    /**
     * @var \Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\LocationValueUrlGenerator
     */
    private $urlGenerator;

    public function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new LocationValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\LocationValueUrlGenerator::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\LocationValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $innerLocation = new EzLocation();
        $location = new Location(['innerLocation' => $innerLocation]);

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(self::identicalTo($innerLocation))
            ->willReturn('/location/path');

        self::assertSame('/location/path', $this->urlGenerator->generate($location));
    }
}
