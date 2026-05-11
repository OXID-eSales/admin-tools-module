<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\CacheClear\Service;

use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Service\ContainerCacheInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Cache\ModuleCacheServiceInterface;
use OxidEsales\Twig\Resolver\TemplateChain\Cache\TemplateChainCacheInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModulesDataProviderInterface;

class Service implements ServiceInterface
{
    public function __construct(
        private ContextInterface $context,
        private ShopTemplateCacheServiceInterface $shopTemplateCache,
        private ShopAdapterInterface $shopAdapter,
        private ContainerCacheInterface $containerCache,
        private ModuleCacheServiceInterface $moduleCacheService,
        private ModulesDataProviderInterface $modulesDataProvider,
        private TemplateChainCacheInterface $templateChainCache
    ) {
    }

    public function clearCurrentShopTemplateCache(): void
    {
        $this->shopTemplateCache->invalidateCache($this->context->getCurrentShopId());
    }

    public function clearCurrentShopInternalCache(): void
    {
        $this->shopAdapter->invalidateModulesCache();
    }

    public function clearCurrentShopContainerCache(): void
    {
        $this->containerCache->invalidate($this->context->getCurrentShopId());
    }

    public function clearCurrentShopModuleCaches(): void
    {
        $moduleIds = $this->modulesDataProvider->getModuleIds();
        foreach ($moduleIds as $moduleId) {
            $this->moduleCacheService->invalidate($moduleId, $this->context->getCurrentShopId());
        }
    }

    public function clearCurrentShopTemplateChainCache(): void
    {
        $this->templateChainCache->invalidate($this->context->getCurrentShopId());
    }

    public function clearAllCurrentShopCaches(): void
    {
        $this->clearCurrentShopInternalCache();
        $this->clearCurrentShopModuleCaches();
        $this->clearCurrentShopTemplateCache();
        $this->clearCurrentShopTemplateChainCache();
        $this->clearCurrentShopContainerCache();
    }
}
