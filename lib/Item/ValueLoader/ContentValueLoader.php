<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueLoader;

use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\ContentInfo;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Throwable;

final class ContentValueLoader implements ValueLoaderInterface
{
    private LoadService $loadService;

    public function __construct(LoadService $loadService)
    {
        $this->loadService = $loadService;
    }

    public function load($id): ?ContentInfo
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

    public function loadByRemoteId($remoteId): ?ContentInfo
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
