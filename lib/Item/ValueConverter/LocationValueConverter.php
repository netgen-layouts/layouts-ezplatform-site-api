<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueConverter;

use eZ\Publish\API\Repository\Values\Content\Location as EzLocation;
use Netgen\BlockManager\Item\ValueConverterInterface;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\Location;

final class LocationValueConverter implements ValueConverterInterface
{
    /**
     * @var \Netgen\BlockManager\Item\ValueConverterInterface
     */
    private $innerConverter;

    /**
     * @var \Netgen\EzPlatformSiteApi\API\LoadService
     */
    private $loadService;

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

    public function getId(object $object)
    {
        if ($object instanceof Location) {
            return $object->id;
        }

        return $this->innerConverter->getId($object);
    }

    public function getRemoteId(object $object)
    {
        if ($object instanceof Location) {
            return $object->remoteId;
        }

        return $this->innerConverter->getRemoteId($object);
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

    public function getObject(object $object): object
    {
        if ($object instanceof EzLocation) {
            return $this->loadService->loadLocation($object->id);
        }

        return $object;
    }
}
