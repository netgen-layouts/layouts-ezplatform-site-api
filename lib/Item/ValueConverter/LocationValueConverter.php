<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueConverter;

use eZ\Publish\API\Repository\Values\Content\Location as EzLocation;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\Location;
use Netgen\Layouts\Item\ValueConverterInterface;

/**
 * @implements \Netgen\Layouts\Item\ValueConverterInterface<\eZ\Publish\API\Repository\Values\Content\Location|\Netgen\EzPlatformSiteApi\API\Values\Location>
 */
final class LocationValueConverter implements ValueConverterInterface
{
    /**
     * @var \Netgen\Layouts\Item\ValueConverterInterface<\eZ\Publish\API\Repository\Values\Content\Location>
     */
    private ValueConverterInterface $innerConverter;

    private LoadService $loadService;

    /**
     * @param \Netgen\Layouts\Item\ValueConverterInterface<\eZ\Publish\API\Repository\Values\Content\Location> $innerConverter
     */
    public function __construct(ValueConverterInterface $innerConverter, LoadService $loadService)
    {
        $this->innerConverter = $innerConverter;
        $this->loadService = $loadService;
    }

    public function supports(object $object): bool
    {
        if ($object instanceof Location) {
            return true;
        }

        return $this->innerConverter->supports($object);
    }

    public function getValueType(object $object): string
    {
        return 'ezlocation';
    }

    public function getId(object $object): int
    {
        if ($object instanceof Location) {
            return (int) $object->id;
        }

        return (int) $this->innerConverter->getId($object);
    }

    public function getRemoteId(object $object): string
    {
        if ($object instanceof Location) {
            return $object->remoteId;
        }

        return (string) $this->innerConverter->getRemoteId($object);
    }

    public function getName(object $object): string
    {
        if ($object instanceof Location) {
            return $object->contentInfo->name;
        }

        return $this->innerConverter->getName($object);
    }

    public function getIsVisible(object $object): bool
    {
        if ($object instanceof Location) {
            return !$object->invisible;
        }

        return $this->innerConverter->getIsVisible($object);
    }

    public function getObject(object $object): Location
    {
        if ($object instanceof EzLocation) {
            return $this->loadService->loadLocation($object->id);
        }

        return $object;
    }
}
