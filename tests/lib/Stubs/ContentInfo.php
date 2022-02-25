<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs;

use Netgen\IbexaSiteApi\API\Values\ContentInfo as APIContentInfo;

final class ContentInfo extends APIContentInfo
{
    protected int $id;

    protected string $remoteId;

    protected string $name;

    protected bool $published;

    protected ?int $mainLocationId;

    protected ?Location $mainLocation;
}
