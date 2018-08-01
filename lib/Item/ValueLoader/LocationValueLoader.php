<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Item\ValueLoader;

use Netgen\BlockManager\Item\ValueLoaderInterface;
use Netgen\EzPlatformSiteApi\API\LoadService;
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

    public function load($id)
    {
        try {
            $location = $this->loadService->loadLocation((int) $id);
        } catch (Throwable $t) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }

    public function loadByRemoteId($remoteId)
    {
        try {
            $location = $this->loadService->loadLocationByRemoteId((string) $remoteId);
        } catch (Throwable $t) {
            return null;
        }

        return $location->contentInfo->published ? $location : null;
    }
}
