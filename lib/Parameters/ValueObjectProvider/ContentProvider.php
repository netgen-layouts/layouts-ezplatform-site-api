<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Parameters\ValueObjectProvider;

use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\Repository;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\Content;
use Netgen\Layouts\Parameters\ValueObjectProviderInterface;

final class ContentProvider implements ValueObjectProviderInterface
{
    private Repository $repository;

    private LoadService $loadService;

    public function __construct(Repository $repository, LoadService $loadService)
    {
        $this->repository = $repository;
        $this->loadService = $loadService;
    }

    public function getValueObject($value): ?object
    {
        try {
            return $this->repository->sudo(
                fn (Repository $repository): Content => $this->loadService->loadContent((int) $value),
            );
        } catch (NotFoundException $e) {
            return null;
        }
    }
}
