<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Parameters\ValueObjectProvider;

use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Repository;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\IbexaSiteApi\API\Values\Location;
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

    public function getValueObject($value): ?object
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
