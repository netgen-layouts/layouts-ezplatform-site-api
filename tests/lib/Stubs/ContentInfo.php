<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Stubs;

use Netgen\EzPlatformSiteApi\API\Values\ContentInfo as APIContentInfo;
use Netgen\EzPlatformSiteApi\API\Values\Node;
use function class_exists;

if (class_exists(Node::class)) {
    require_once __DIR__ . '/Legacy/ContentInfo.php';
} else {
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
    }
}
