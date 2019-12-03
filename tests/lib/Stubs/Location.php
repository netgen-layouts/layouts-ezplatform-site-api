<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Stubs;

use Netgen\EzPlatformSiteApi\API\Values\Location as APILocation;
use Netgen\EzPlatformSiteApi\API\Values\Node;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;

if (class_exists(Node::class)) {
    require_once __DIR__ . '/Legacy/Location.php';
} else {
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

        public function filterChildren(array $contentTypeIdentifiers = [], int $maxPerPage = 25, int $currentPage = 1): Pagerfanta
        {
            return new Pagerfanta(
                new class() implements AdapterInterface {
                    public function getNbResults(): int
                    {
                        return 0;
                    }

                    public function getSlice($offset, $length): iterable
                    {
                        return [];
                    }
                }
            );
        }

        public function getSiblings(int $limit = 25): array
        {
            return [];
        }

        public function filterSiblings(array $contentTypeIdentifiers = [], int $maxPerPage = 25, int $currentPage = 1): Pagerfanta
        {
            return new Pagerfanta(
                new class() implements AdapterInterface {
                    public function getNbResults(): int
                    {
                        return 0;
                    }

                    public function getSlice($offset, $length): iterable
                    {
                        return [];
                    }
                }
            );
        }
    }
}
