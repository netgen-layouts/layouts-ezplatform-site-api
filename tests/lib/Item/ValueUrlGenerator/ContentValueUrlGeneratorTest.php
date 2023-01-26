<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Tests\Item\ValueUrlGenerator;

use Ibexa\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\ContentInfo;
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
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator::generateDefaultUrl
     */
    public function testGenerateDefaultUrl(): void
    {
        $contentInfo = new ContentInfo(
            [
                'id' => 42,
            ],
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo(UrlAliasRouter::URL_ALIAS_ROUTE_NAME),
                self::identicalTo(['contentId' => 42]),
            )
            ->willReturn('/content/path');

        self::assertSame('/content/path', $this->urlGenerator->generateDefaultUrl($contentInfo));
    }

    /**
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator::generateAdminUrl
     */
    public function testGenerateAdminUrl(): void
    {
        $contentInfo = new ContentInfo(
            [
                'id' => 42,
            ],
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo('ibexa.content.view'),
                self::identicalTo(['contentId' => 42]),
            )
            ->willReturn('/admin/content/path');

        self::assertSame('/admin/content/path', $this->urlGenerator->generateAdminUrl($contentInfo));
    }

    /**
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator\ContentValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $contentInfo = new ContentInfo(
            [
                'id' => 42,
            ],
        );

        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo(UrlAliasRouter::URL_ALIAS_ROUTE_NAME),
                self::identicalTo(['contentId' => 42]),
            )
            ->willReturn('/content/path');

        self::assertSame('/content/path', $this->urlGenerator->generate($contentInfo));
    }
}
