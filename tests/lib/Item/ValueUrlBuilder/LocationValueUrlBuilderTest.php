<?php

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueUrlBuilder;

use eZ\Publish\Core\Repository\Values\Content\Location as EzLocation;
use Netgen\BlockManager\SiteAPI\Item\ValueUrlBuilder\LocationValueUrlBuilder;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\Location;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class LocationValueUrlBuilderTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $urlGenerator;

    /**
     * @var \Netgen\BlockManager\SiteAPI\Item\ValueUrlBuilder\LocationValueUrlBuilder
     */
    private $urlBuilder;

    public function setUp()
    {
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);

        $this->urlBuilder = new LocationValueUrlBuilder($this->urlGenerator);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueUrlBuilder\LocationValueUrlBuilder::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueUrlBuilder\LocationValueUrlBuilder::getUrl
     */
    public function testGetUrl()
    {
        $location = new Location(
            array(
                'innerLocation' => new EzLocation(),
            )
        );

        $this->urlGenerator
            ->expects($this->once())
            ->method('generate')
            ->with($this->equalTo(new EzLocation()))
            ->will($this->returnValue('/location/path'));

        $this->assertEquals('/location/path', $this->urlBuilder->getUrl($location));
    }
}
