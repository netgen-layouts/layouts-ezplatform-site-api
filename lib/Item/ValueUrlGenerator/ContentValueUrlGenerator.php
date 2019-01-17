<?php

declare(strict_types=1);

namespace Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator;

use eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter;
use Netgen\BlockManager\Item\ValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ContentValueUrlGenerator implements ValueUrlGeneratorInterface
{
    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param \Netgen\EzPlatformSiteApi\API\Values\ContentInfo $object
     */
    public function generate($object): ?string
    {
        return $this->urlGenerator->generate(
            UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
            [
                'contentId' => $object->id,
            ]
        );
    }
}
