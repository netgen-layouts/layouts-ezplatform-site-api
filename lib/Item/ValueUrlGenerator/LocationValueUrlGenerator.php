<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ez\SiteApi\Item\ValueUrlGenerator;

use Netgen\BlockManager\Item\ValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class LocationValueUrlGenerator implements ValueUrlGeneratorInterface
{
    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generate(object $object): ?string
    {
        return $this->urlGenerator->generate($object->innerLocation);
    }
}
