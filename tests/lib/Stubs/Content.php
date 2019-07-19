<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Tests\Stubs;

use eZ\Publish\Core\FieldType\Null\Value as NullValue;
use eZ\Publish\SPI\FieldType\Value;
use Netgen\EzPlatformSiteApi\API\Values\Content as APIContent;
use Netgen\EzPlatformSiteApi\API\Values\Field as APIField;
use Netgen\EzPlatformSiteApi\API\Values\Node;
use Netgen\EzPlatformSiteApi\Core\Site\Values\Field;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;

if (class_exists(Node::class)) {
    require_once __DIR__ . '/Legacy/Content.php';
} else {
    final class Content extends APIContent
    {
        /**
         * @var int
         */
        protected $id;

        /**
         * @var \Netgen\EzPlatformSiteApi\API\Values\ContentInfo
         */
        protected $contentInfo;

        public function hasField(string $identifier): bool
        {
            return false;
        }

        public function getField(string $identifier): APIField
        {
            return new Field();
        }

        public function hasFieldById($id): bool
        {
            return false;
        }

        public function getFieldById($id): APIField
        {
            return new Field();
        }

        public function getFieldValue(string $identifier): Value
        {
            return new NullValue();
        }

        public function getFieldValueById($id): Value
        {
            return new NullValue();
        }

        public function getLocations(int $limit = 25): array
        {
            return [];
        }

        public function filterLocations(int $maxPerPage = 25, int $currentPage = 1): array
        {
            return [];
        }

        public function getFieldRelation(string $fieldDefinitionIdentifier): ?APIContent
        {
            return new self();
        }

        public function getFieldRelations(string $fieldDefinitionIdentifier, int $limit = 25): array
        {
            return [];
        }

        public function filterFieldRelations(
            string $fieldDefinitionIdentifier,
            array $contentTypeIdentifiers = [],
            int $maxPerPage = 25,
            int $currentPage = 1
        ): Pagerfanta {
            return new Pagerfanta(
                new class() implements AdapterInterface {
                    public function getNbResults(): int
                    {
                        return 0;
                    }

                    public function getSlice($offset, $length): array
                    {
                        return [];
                    }
                }
            );
        }
    }
}
