<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Tests\Item\ValueConverter;

use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo as IbexaContentInfo;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\Layouts\Ibexa\SiteApi\Item\ValueConverter\ContentValueConverter;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\Content;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\ContentInfo;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\Location;
use Netgen\Layouts\Item\ValueConverterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(ContentValueConverter::class)]
final class ContentValueConverterTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject&\Netgen\Layouts\Item\ValueConverterInterface<\Netgen\IbexaSiteApi\API\Values\Content>
     */
    private MockObject&ValueConverterInterface $innerConverterMock;

    private MockObject&LoadService $loadServiceMock;

    private ContentValueConverter $valueConverter;

    protected function setUp(): void
    {
        $this->innerConverterMock = $this->createMock(ValueConverterInterface::class);
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->valueConverter = new ContentValueConverter(
            $this->innerConverterMock,
            $this->loadServiceMock,
        );
    }

    public function testSupports(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('supports');

        self::assertTrue($this->valueConverter->supports(new ContentInfo()));
    }

    public function testSupportsWithoutSiteApiContentInfo(): void
    {
        $contentInfo = new IbexaContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('supports')
            ->with(self::identicalTo($contentInfo))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->supports($contentInfo));
    }

    public function testGetValueType(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getValueType');

        self::assertSame(
            'ibexa_content',
            $this->valueConverter->getValueType(
                new ContentInfo(),
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
                new ContentInfo(['id' => 24]),
            ),
        );
    }

    public function testGetIdWithoutSiteApiContentInfo(): void
    {
        $contentInfo = new IbexaContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getId')
            ->with(self::identicalTo($contentInfo))
            ->willReturn(42);

        self::assertSame(42, $this->valueConverter->getId($contentInfo));
    }

    public function testGetRemoteId(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getRemoteId');

        self::assertSame(
            'abc',
            $this->valueConverter->getRemoteId(
                new ContentInfo(['remoteId' => 'abc']),
            ),
        );
    }

    public function testGetRemoteIdWithoutSiteApiContentInfo(): void
    {
        $contentInfo = new IbexaContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getRemoteId')
            ->with(self::identicalTo($contentInfo))
            ->willReturn('abc');

        self::assertSame('abc', $this->valueConverter->getRemoteId($contentInfo));
    }

    public function testGetName(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getName');

        self::assertSame(
            'Cool name',
            $this->valueConverter->getName(
                new ContentInfo(['name' => 'Cool name']),
            ),
        );
    }

    public function testGetNameWithoutSiteApiContentInfo(): void
    {
        $contentInfo = new IbexaContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getName')
            ->with(self::identicalTo($contentInfo))
            ->willReturn('Cool name');

        self::assertSame('Cool name', $this->valueConverter->getName($contentInfo));
    }

    public function testGetIsVisible(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getIsVisible');

        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new ContentInfo(['mainLocation' => new Location(['invisible' => false])]),
            ),
        );
    }

    public function testGetIsVisibleWithoutMainLocation(): void
    {
        $this->innerConverterMock
            ->expects(self::never())
            ->method('getIsVisible');

        self::assertFalse(
            $this->valueConverter->getIsVisible(
                new ContentInfo(['mainLocation' => new Location(['invisible' => true])]),
            ),
        );
    }

    public function testGetIsVisibleWithoutSiteApiContentInfo(): void
    {
        $contentInfo = new IbexaContentInfo();

        $this->innerConverterMock
            ->expects(self::once())
            ->method('getIsVisible')
            ->with(self::identicalTo($contentInfo))
            ->willReturn(true);

        self::assertTrue($this->valueConverter->getIsVisible($contentInfo));
    }

    public function testGetObject(): void
    {
        $this->loadServiceMock
            ->expects(self::never())
            ->method('loadContent');

        $object = new ContentInfo(['id' => 42]);

        self::assertSame($object, $this->valueConverter->getObject($object));
    }

    public function testGetObjectWithoutSiteApiContentInfo(): void
    {
        $contentInfo = new ContentInfo();
        $content = new Content(['contentInfo' => $contentInfo]);

        $this->loadServiceMock
            ->expects(self::once())
            ->method('loadContent')
            ->with(self::identicalTo(42))
            ->willReturn($content);

        self::assertSame($contentInfo, $this->valueConverter->getObject(new IbexaContentInfo(['id' => 42])));
    }
}
