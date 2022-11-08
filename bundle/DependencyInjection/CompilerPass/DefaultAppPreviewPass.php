<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsIbexaSiteApiBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function is_array;

final class DefaultAppPreviewPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('ibexa.site_access.list')) {
            return;
        }

        $defaultRule = [
            'template' => $container->getParameter(
                'netgen_layouts.app.ibexa.item_preview_template',
            ),
            'match' => [],
            'params' => [],
        ];

        /** @var string[] $siteAccessList */
        $siteAccessList = $container->getParameter('ibexa.site_access.list');
        $scopes = [...['default'], ...$siteAccessList];

        foreach ($scopes as $scope) {
            if ($container->hasParameter("ibexa.site_access.config.{$scope}.ng_content_view")) {
                // For Site API v3 support
                /** @var array<string, mixed[]>|null $scopeRules */
                $scopeRules = $container->getParameter("ibexa.site_access.config.{$scope}.ng_content_view");
                $scopeRules = $this->addDefaultPreviewRule($scopeRules, $defaultRule);
                $container->setParameter("ibexa.site_access.config.{$scope}.ng_content_view", $scopeRules);
            }

            if ($container->hasParameter("ibexa.site_access.config.{$scope}.ng_content_view")) {
                // For Site API v4 support
                /** @var array<string, mixed[]>|null $scopeRules */
                $scopeRules = $container->getParameter("ibexa.site_access.config.{$scope}.ng_content_view");
                $scopeRules = $this->addDefaultPreviewRule($scopeRules, $defaultRule);
                $container->setParameter("ibexa.site_access.config.{$scope}.ng_content_view", $scopeRules);
            }
        }
    }

    /**
     * Adds the default Site API content preview template to default scope as a fallback
     * when no preview rules are defined.
     *
     * @param array<string, mixed[]>|null $scopeRules
     * @param array<string, mixed> $defaultRule
     *
     * @return array<string, mixed[]>
     */
    private function addDefaultPreviewRule(?array $scopeRules, array $defaultRule): array
    {
        $scopeRules = is_array($scopeRules) ? $scopeRules : [];

        $layoutsRules = $scopeRules['nglayouts_app_preview'] ?? [];

        $layoutsRules += [
            '___nglayouts_app_preview_default___' => $defaultRule,
        ];

        $scopeRules['nglayouts_app_preview'] = $layoutsRules;

        return $scopeRules;
    }
}
