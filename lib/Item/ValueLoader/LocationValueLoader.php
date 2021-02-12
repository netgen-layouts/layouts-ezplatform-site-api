<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueLoader;

use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\Location;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Throwable;

final class LocationValueLoader implements ValueLoaderInterface
{
    private LoadService $loadService;

    public function __construct(LoadService $loadService)
    {
        $this->loadService = $loadService;
    }

    public function load($id): ?Location
    {
        try {
            $location = $this->loadService->loadLocation((int) $id);
        } catch (Throwable $t) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }

    public function loadByRemoteId($remoteId): ?Location
    {
        try {
            $location = $this->loadService->loadLocationByRemoteId((string) $remoteId);
        } catch (Throwable $t) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }
}
