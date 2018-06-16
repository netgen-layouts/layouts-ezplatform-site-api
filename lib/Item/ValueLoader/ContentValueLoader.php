<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Item\ValueLoader;

use Netgen\BlockManager\Exception\Item\ItemException;
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

    public function load($id)
    {
        try {
            $contentInfo = $this->loadService->loadContent((int) $id)->contentInfo;
        } catch (Throwable $t) {
            throw new ItemException(
                sprintf('Content with ID "%s" could not be loaded.', $id),
                0,
                $t
            );
        }

        if (!$contentInfo->published) {
            throw new ItemException(
                sprintf('Content with ID "%s" is not published and cannot loaded.', $id)
            );
        }

        if ($contentInfo->mainLocationId === null) {
            throw new ItemException(
                sprintf('Content with ID "%s" does not have a main location and cannot loaded.', $id)
            );
        }

        return $contentInfo;
    }

    public function loadByRemoteId($remoteId)
    {
        try {
            $contentInfo = $this->loadService->loadContentByRemoteId((string) $remoteId)->contentInfo;
        } catch (Throwable $t) {
            throw new ItemException(
                sprintf('Content with remote ID "%s" could not be loaded.', $remoteId),
                0,
                $t
            );
        }

        if (!$contentInfo->published) {
            throw new ItemException(
                sprintf('Content with remote ID "%s" is not published and cannot loaded.', $remoteId)
            );
        }

        if ($contentInfo->mainLocationId === null) {
            throw new ItemException(
                sprintf('Content with remote ID "%s" does not have a main location and cannot loaded.', $remoteId)
            );
        }

        return $contentInfo;
    }
}
