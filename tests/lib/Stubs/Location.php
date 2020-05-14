<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Stubs;

use Netgen\EzPlatformSiteApi\API\Values\Location as APILocation;
use Pagerfanta\Pagerfanta;

final class Location extends APILocation
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $remoteId;

    /**
     * @var bool
     */
    protected $invisible;

    /**
     * @var \Netgen\EzPlatformSiteApi\API\Values\ContentInfo
     */
    protected $contentInfo;

    /**
     * @var \eZ\Publish\API\Repository\Values\Content\Location
     */
    protected $innerLocation;

    public function getChildren(int $limit = 25): array
    {
        return [];
    }

    /**
     * @param array<mixed> $contentTypeIdentifiers
     *
     * @return \Pagerfanta\Pagerfanta<\Netgen\EzPlatformSiteApi\API\Values\Location>
     */
    public function filterChildren(array $contentTypeIdentifiers = [], int $maxPerPage = 25, int $currentPage = 1): Pagerfanta
    {
        return new Pagerfanta(new Adapter());
    }

    public function getFirstChild(?string $contentTypeIdentifier = null): ?APILocation
    {
        return null;
    }

    public function getSiblings(int $limit = 25): array
    {
        return [];
    }

    /**
     * @param array<mixed> $contentTypeIdentifiers
     *
     * @return \Pagerfanta\Pagerfanta<\Netgen\EzPlatformSiteApi\API\Values\Location>
     */
    public function filterSiblings(array $contentTypeIdentifiers = [], int $maxPerPage = 25, int $currentPage = 1): Pagerfanta
    {
        return new Pagerfanta(new Adapter());
    }
}
