<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\AdminTools\CacheClear\Service;

use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Service\ContainerCacheInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Cache\ModuleCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\TemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;

interface ServiceInterface
{
    public function clearCurrentShopTemplateCache(): void;

    public function clearCurrentShopInternalCache(): void;

    public function clearCurrentShopContainerCache(): void;

    public function clearCurrentShopModuleCaches(): void;

    public function clearCurrentShopTemplateChainCache(): void;

    public function clearCurrentShopGraphQLSchemaCache(): void;

    public function clearAllCurrentShopCaches(): void;
}
