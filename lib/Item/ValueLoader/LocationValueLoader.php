<?php

namespace Netgen\BlockManager\SiteAPI\Item\ValueLoader;

use Exception;
use Netgen\BlockManager\Exception\Item\ItemException;
use Netgen\BlockManager\Item\ValueLoaderInterface;
use Netgen\EzPlatformSiteApi\API\LoadService;

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
        } catch (Exception $e) {
            throw new ItemException(
                sprintf('Location with ID "%s" could not be loaded.', $id),
                0,
                $e
            );
        }

        if (!$location->contentInfo->published) {
            throw new ItemException(
                sprintf('Location with ID "%s" has unpublished content and cannot be loaded.', $id)
            );
        }

        return $location;
    }

    public function loadByRemoteId($remoteId)
    {
        try {
            $location = $this->loadService->loadLocationByRemoteId((string) $remoteId);
        } catch (Exception $e) {
            throw new ItemException(
                sprintf('Location with remote ID "%s" could not be loaded.', $remoteId),
                0,
                $e
            );
        }

        if (!$location->contentInfo->published) {
            throw new ItemException(
                sprintf('Location with remote ID "%s" has unpublished content and cannot be loaded.', $remoteId)
            );
        }

        return $location;
    }
}
