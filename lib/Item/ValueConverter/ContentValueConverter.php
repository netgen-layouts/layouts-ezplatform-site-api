<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueConverter;

use eZ\Publish\API\Repository\Values\Content\ContentInfo as EzContentInfo;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\ContentInfo;
use Netgen\Layouts\Item\ValueConverterInterface;

/**
 * @implements \Netgen\Layouts\Item\ValueConverterInterface<\eZ\Publish\API\Repository\Values\Content\ContentInfo|\Netgen\EzPlatformSiteApi\API\Values\ContentInfo>
 */
final class ContentValueConverter implements ValueConverterInterface
{
    /**
     * @var \Netgen\Layouts\Item\ValueConverterInterface<\eZ\Publish\API\Repository\Values\Content\ContentInfo>
     */
    private ValueConverterInterface $innerConverter;

    private LoadService $loadService;

    /**
     * @param \Netgen\Layouts\Item\ValueConverterInterface<\eZ\Publish\API\Repository\Values\Content\ContentInfo> $innerConverter
     */
    public function __construct(ValueConverterInterface $innerConverter, LoadService $loadService)
    {
        $this->innerConverter = $innerConverter;
        $this->loadService = $loadService;
    }

    public function supports(object $object): bool
    {
        if ($object instanceof ContentInfo) {
            return true;
        }

        return $this->innerConverter->supports($object);
    }

    public function getValueType(object $object): string
    {
        return 'ezcontent';
    }

    public function getId(object $object): int
    {
        if ($object instanceof ContentInfo) {
            return (int) $object->id;
        }

        return (int) $this->innerConverter->getId($object);
    }

    public function getRemoteId(object $object): string
    {
        if ($object instanceof ContentInfo) {
            return $object->remoteId;
        }

        return (string) $this->innerConverter->getRemoteId($object);
    }

    public function getName(object $object): string
    {
        if ($object instanceof ContentInfo) {
            return $object->name;
        }

        return $this->innerConverter->getName($object);
    }

    public function getIsVisible(object $object): bool
    {
        if ($object instanceof ContentInfo) {
            return $object->mainLocation !== null && !$object->mainLocation->invisible;
        }

        return $this->innerConverter->getIsVisible($object);
    }

    public function getObject(object $object): ContentInfo
    {
        if ($object instanceof EzContentInfo) {
            return $this->loadService->loadContent($object->id)->contentInfo;
        }

        return $object;
    }
}
