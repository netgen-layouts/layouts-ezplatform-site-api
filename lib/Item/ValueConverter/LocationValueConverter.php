<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Item\ValueConverter;

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

    public function supports($object): bool
    {
        if ($object instanceof Location) {
            return true;
        }

        return $this->innerConverter->supports($object);
    }

    public function getValueType($object): string
    {
        return 'ezlocation';
    }

    public function getId($object)
    {
        if ($object instanceof Location) {
            return $object->id;
        }

        return $this->innerConverter->getId($object);
    }

    public function getRemoteId($object)
    {
        if ($object instanceof Location) {
            return $object->remoteId;
        }

        return $this->innerConverter->getRemoteId($object);
    }

    public function getName($object): string
    {
        if ($object instanceof Location) {
            return $object->contentInfo->name;
        }

        return $this->innerConverter->getName($object);
    }

    public function getIsVisible($object): bool
    {
        if ($object instanceof Location) {
            return !$object->invisible;
        }

        return $this->innerConverter->getIsVisible($object);
    }

    public function getObject($object)
    {
        if ($object instanceof Location) {
            return $object;
        }

        return $this->loadService->loadLocation($object->id);
    }
}
