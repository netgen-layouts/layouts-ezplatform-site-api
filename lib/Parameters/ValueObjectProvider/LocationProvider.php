<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Parameters\ValueObjectProvider;

use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Repository;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\IbexaSiteApi\API\Values\Location;
use Netgen\Layouts\Error\ErrorHandlerInterface;
use Netgen\Layouts\Parameters\ValueObjectProviderInterface;

final class LocationProvider implements ValueObjectProviderInterface
{
    public function __construct(
        private Repository $repository,
        private LoadService $loadService,
        private ErrorHandlerInterface $errorHandler,
    ) {
    }

    public function getValueObject(mixed $value): ?Location
    {
        if ($value === null) {
            return null;
        }

        try {
            return $this->repository->sudo(
                fn (): Location => $this->loadService->loadLocation((int) $value),
            );
        } catch (NotFoundException $e) {
            $this->errorHandler->logError($e);

            return null;
        }
    }
}
