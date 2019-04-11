<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueLoader;

use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Throwable;

final class LocationValueLoader implements ValueLoaderInterface
{
    /**
     * @var \Netgen\EzPlatformSiteApi\API\LoadService
     */
    private $loadService;

    public function __construct(LoadService $loadService)
    {
        $this->loadService = $loadService;
    }

    public function load($id): ?object
    {
        try {
            $location = $this->loadService->loadLocation((int) $id);
        } catch (Throwable $t) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }

    public function loadByRemoteId($remoteId): ?object
    {
        try {
            $location = $this->loadService->loadLocationByRemoteId((string) $remoteId);
        } catch (Throwable $t) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }
}
