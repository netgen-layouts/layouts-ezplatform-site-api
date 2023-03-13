<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Item\ValueConverter;

use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo as IbexaContentInfo;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\IbexaSiteApi\API\Values\ContentInfo;
use Netgen\Layouts\Item\ValueConverterInterface;

/**
 * @implements \Netgen\Layouts\Item\ValueConverterInterface<\Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo|\Netgen\IbexaSiteApi\API\Values\ContentInfo>
 */
final class ContentValueConverter implements ValueConverterInterface
{
    /**
     * @param \Netgen\Layouts\Item\ValueConverterInterface<\Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo> $innerConverter
     */
    public function __construct(private ValueConverterInterface $innerConverter, private LoadService $loadService)
    {
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
        return 'ibexa_content';
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
            return (string) $object->name;
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
        if ($object instanceof IbexaContentInfo) {
            return $this->loadService->loadContent($object->id)->contentInfo;
        }

        return $object;
    }
}
