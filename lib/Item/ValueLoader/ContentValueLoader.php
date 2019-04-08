<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Item\ValueLoader;

use Netgen\BlockManager\Item\ValueLoaderInterface;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Throwable;

final class ContentValueLoader implements ValueLoaderInterface
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
            $contentInfo = $this->loadService->loadContent((int) $id)->contentInfo;
        } catch (Throwable $t) {
            return null;
        }

        if (!$contentInfo->published || $contentInfo->mainLocationId === null) {
            return null;
        }

        return $contentInfo;
    }

    public function loadByRemoteId($remoteId): ?object
    {
        try {
            $contentInfo = $this->loadService->loadContentByRemoteId((string) $remoteId)->contentInfo;
        } catch (Throwable $t) {
            return null;
        }

        if (!$contentInfo->published || $contentInfo->mainLocationId === null) {
            return null;
        }

        return $contentInfo;
    }
}
