<?php

namespace Netgen\BlockManager\SiteAPI\Item\ValueConverter;

use Netgen\BlockManager\Item\ValueConverterInterface;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\Location;

final class LocationValueConverter implements ValueConverterInterface
{
    /**
     * @var \Netgen\BlockManager\Item\ValueConverterInterface
     */
    private $decoratedConverter;

    /**
     * @var \Netgen\EzPlatformSiteApi\API\LoadService
     */
    private $loadService;

    public function __construct(ValueConverterInterface $decoratedConverter, LoadService $loadService)
    {
        $this->decoratedConverter = $decoratedConverter;
        $this->loadService = $loadService;
    }

    public function supports($object)
    {
        if ($object instanceof Location) {
            return true;
        }

        return $this->decoratedConverter->supports($object);
    }

    public function getValueType($object)
    {
        return 'ezlocation';
    }

    public function getId($object)
    {
        if ($object instanceof Location) {
            return $object->id;
        }

        return $this->decoratedConverter->getId($object);
    }

    public function getRemoteId($object)
    {
        if ($object instanceof Location) {
            return $object->remoteId;
        }

        return $this->decoratedConverter->getRemoteId($object);
    }

    public function getName($object)
    {
        if ($object instanceof Location) {
            return $object->contentInfo->name;
        }

        return $this->decoratedConverter->getName($object);
    }

    public function getIsVisible($object)
    {
        if ($object instanceof Location) {
            return !$object->invisible;
        }

        return $this->decoratedConverter->getIsVisible($object);
    }

    public function getObject($object)
    {
        if ($object instanceof Location) {
            return $object;
        }

        return $this->loadService->loadLocation($object->id);
    }
}
