<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use function is_array;

final class DefaultContentBrowserPreviewPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('ezpublish.siteaccess.list')) {
            return;
        }

        $defaultRule = [
            'template' => $container->getParameter(
                'netgen_content_browser.ezplatform.preview_template',
            ),
            'match' => [],
            'params' => [],
        ];

        /** @var string[] $siteAccessList */
        $siteAccessList = $container->getParameter('ezpublish.siteaccess.list');
        $scopes = [...['default'], ...$siteAccessList];

        foreach ($scopes as $scope) {
            if ($container->hasParameter("ezsettings.{$scope}.ngcontent_view")) {
                // For Site API v3 support
                /** @var array<string, array>|null $scopeRules */
                $scopeRules = $container->getParameter("ezsettings.{$scope}.ngcontent_view");
                $scopeRules = $this->addDefaultPreviewRule($scopeRules, $defaultRule);
                $container->setParameter("ezsettings.{$scope}.ngcontent_view", $scopeRules);
            }

            if ($container->hasParameter("ezsettings.{$scope}.ng_content_view")) {
                // For Site API v4 support
                /** @var array<string, array>|null $scopeRules */
                $scopeRules = $container->getParameter("ezsettings.{$scope}.ng_content_view");
                $scopeRules = $this->addDefaultPreviewRule($scopeRules, $defaultRule);
                $container->setParameter("ezsettings.{$scope}.ng_content_view", $scopeRules);
            }
        }
    }

    /**
     * Adds the default Site API content preview template to default scope as a fallback
     * when no preview rules are defined.
     *
     * @param array<string, array>|null $scopeRules
     * @param array<string, mixed> $defaultRule
     *
     * @return array<string, array>
     */
    private function addDefaultPreviewRule(?array $scopeRules, array $defaultRule): array
    {
        $scopeRules = is_array($scopeRules) ? $scopeRules : [];

        $contentBrowserRules = $scopeRules['ngcb_preview'] ?? [];

        $contentBrowserRules += [
            '___ngcb_preview_default___' => $defaultRule,
        ];

        $scopeRules['ngcb_preview'] = $contentBrowserRules;

        return $scopeRules;
    }
}
