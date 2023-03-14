<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Parameters\ValueObjectProvider;

use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Repository;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\IbexaSiteApi\API\Values\Content;
use Netgen\Layouts\Parameters\ValueObjectProviderInterface;

final class ContentProvider implements ValueObjectProviderInterface
{
    public function __construct(private Repository $repository, private LoadService $loadService)
    {
    }

    public function getValueObject(mixed $value): ?Content
    {
        try {
            $content = $this->repository->sudo(
                fn (): Content => $this->loadService->loadContent((int) $value),
            );

            return $content->contentInfo->mainLocationId !== null ? $content : null;
        } catch (NotFoundException) {
            return null;
        }
    }
}
