<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator;

use eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\Layouts\Item\ValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @implements \Netgen\Layouts\Item\ValueUrlGeneratorInterface<\eZ\Publish\API\Repository\Values\Content\ContentInfo|\Netgen\EzPlatformSiteApi\API\Values\ContentInfo>
 */
final class ContentValueUrlGenerator implements ValueUrlGeneratorInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generate(object $object): string
    {
        return $this->urlGenerator->generate(
            UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
            [
                'contentId' => $object->id,
            ],
        );
    }
}
