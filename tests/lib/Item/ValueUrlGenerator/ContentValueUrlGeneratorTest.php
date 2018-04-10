<?php

namespace Netgen\BlockManager\SiteAPI\Tests\Item\ValueUrlGenerator;

use eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\ContentValueUrlGenerator;
use Netgen\BlockManager\SiteAPI\Tests\Stubs\ContentInfo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ContentValueUrlGeneratorTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $urlGeneratorMock;

    /**
     * @var \Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\ContentValueUrlGenerator
     */
    private $urlGenerator;

    public function setUp()
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new ContentValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\ContentValueUrlGenerator::__construct
     * @covers \Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator\ContentValueUrlGenerator::generate
     */
    public function testGetUrl()
    {
        $contentInfo = new ContentInfo(
            array(
                'id' => 42,
            )
        );

        $this->urlGeneratorMock
            ->expects($this->once())
            ->method('generate')
            ->with(
                $this->equalTo(UrlAliasRouter::URL_ALIAS_ROUTE_NAME),
                array(
                    'contentId' => 42,
                )
            )
            ->will($this->returnValue('/content/path'));

        $this->assertEquals('/content/path', $this->urlGenerator->generate($contentInfo));
    }
}
