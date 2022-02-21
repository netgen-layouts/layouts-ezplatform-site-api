<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs;

use Pagerfanta\Adapter\AdapterInterface;

final class Adapter implements AdapterInterface
{
    public function getNbResults(): int
    {
        return 0;
    }

    /**
     * @param int $offset
     * @param int $length
     *
     * @return iterable<int, \Netgen\EzPlatformSiteApi\API\Values\Location>
     */
    public function getSlice($offset, $length): iterable
    {
        return [];
    }
}
