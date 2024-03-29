<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Parameters\ValueObjectProvider;

use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\Repository;
use Netgen\EzPlatformSiteApi\API\LoadService;
use Netgen\EzPlatformSiteApi\API\Values\Content;
use Netgen\Layouts\Error\ErrorHandlerInterface;
use Netgen\Layouts\Parameters\ValueObjectProviderInterface;

final class ContentProvider implements ValueObjectProviderInterface
{
    private Repository $repository;

    private LoadService $loadService;

    private ErrorHandlerInterface $errorHandler;

    public function __construct(
        Repository $repository,
        LoadService $loadService,
        ErrorHandlerInterface $errorHandler
    ) {
        $this->repository = $repository;
        $this->loadService = $loadService;
        $this->errorHandler = $errorHandler;
    }

    public function getValueObject($value): ?Content
    {
        if ($value === null) {
            return null;
        }

        try {
            $content = $this->repository->sudo(
                fn (Repository $repository): Content => $this->loadService->loadContent((int) $value),
            );

            return $content->contentInfo->mainLocationId !== null ? $content : null;
        } catch (NotFoundException $e) {
            $this->errorHandler->logError($e);

            return null;
        }
    }
}
