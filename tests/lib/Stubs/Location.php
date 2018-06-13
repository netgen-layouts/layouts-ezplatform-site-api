<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Tests\Stubs;

use Netgen\EzPlatformSiteApi\API\Values\Location as APILocation;

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

    public function getChildren($limit = 25)
    {
    }

    public function filterChildren(array $contentTypeIdentifiers = [], $maxPerPage = 25, $currentPage = 1)
    {
    }

    public function getSiblings($limit = 25)
    {
    }

    public function filterSiblings(array $contentTypeIdentifiers = [], $maxPerPage = 25, $currentPage = 1)
    {
    }
}
