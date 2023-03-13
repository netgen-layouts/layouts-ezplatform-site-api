<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Item\ValueLoader;

use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\IbexaSiteApi\API\Values\Location;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Throwable;

final class LocationValueLoader implements ValueLoaderInterface
{
    public function __construct(private LoadService $loadService)
    {
    }

    public function load($id): ?Location
    {
        try {
            $location = $this->loadService->loadLocation((int) $id);
        } catch (Throwable) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }

    public function loadByRemoteId($remoteId): ?Location
    {
        try {
            $location = $this->loadService->loadLocationByRemoteId((string) $remoteId);
        } catch (Throwable) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }
}
