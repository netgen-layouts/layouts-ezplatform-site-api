<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Parameters\ValueObjectProvider;

use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\Repository;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\Location;
use Netgen\Layouts\Parameters\ValueObjectProviderInterface;

final class LocationProvider implements ValueObjectProviderInterface
{
    private Repository $repository;

    private LoadService $loadService;

    public function __construct(Repository $repository, LoadService $loadService)
    {
        $this->repository = $repository;
        $this->loadService = $loadService;
    }

    public function getValueObject($value): ?Location
    {
        try {
            return $this->repository->sudo(
                fn (Repository $repository): Location => $this->loadService->loadLocation((int) $value),
            );
        } catch (NotFoundException $e) {
            return null;
        }
    }
}
