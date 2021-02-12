<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Item\ValueUrlGenerator;

use eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator;
use Netgen\Layouts\Ez\SiteApi\Tests\Stubs\ContentInfo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ContentValueUrlGeneratorTest extends TestCase
{
    private MockObject $urlGeneratorMock;

    private ContentValueUrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new ContentValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $contentInfo = new ContentInfo(
            [
                'id' => 42,
            ]
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo(UrlAliasRouter::URL_ALIAS_ROUTE_NAME),
                self::identicalTo(['contentId' => 42])
            )
            ->willReturn('/content/path');

        self::assertSame('/content/path', $this->urlGenerator->generate($contentInfo));
    }
}
