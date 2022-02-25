<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Item\ValueUrlGenerator;

use Ibexa\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\Layouts\Item\ValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @implements \Netgen\Layouts\Item\ValueUrlGeneratorInterface<\Ibexa\Contracts\Core\Repository\Values\Content\Location|\Netgen\IbexaSiteApi\API\Values\Location>
 */
final class LocationValueUrlGenerator implements ValueUrlGeneratorInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generate(object $object): ?string
    {
        return $this->urlGenerator->generate(
            UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
            [
                'locationId' => $object->id,
            ],
        );
    }
}
