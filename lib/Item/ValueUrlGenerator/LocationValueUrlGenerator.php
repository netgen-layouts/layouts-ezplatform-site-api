<?php

namespace Netgen\BlockManager\SiteAPI\Item\ValueUrlGenerator;

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

    public function generate($object)
    {
        return $this->urlGenerator->generate($object->innerLocation);
    }
}