<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Stubs;

use Netgen\EzPlatformSiteApi\API\Values\ContentInfo as APIContentInfo;

final class ContentInfo extends APIContentInfo
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
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $published;

    /**
     * @var int
     */
    protected $mainLocationId;

    /**
     * @var \Netgen\EzPlatformSiteApi\API\Values\Location
     */
    protected $mainLocation;

    public function getLocations($limit = 25)
    {
    }

    public function filterLocations($maxPerPage = 25, $currentPage = 1)
    {
    }
}
