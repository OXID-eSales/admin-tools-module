<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Unit\CacheClear\Service;

use OxidEsales\AdminTools\CacheClear\Service\Service;
use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Service\ContainerCacheInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Cache\ModuleCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModulesDataProviderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\Twig\Resolver\TemplateChain\Cache\TemplateChainCacheInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Service::class)]
class ServiceTest extends TestCase
{
    public function testClearCurrentShopTemplateCache(): void
    {
        $context = $this->createConfiguredStub(
            ContextInterface::class,
            ['getCurrentShopId' => 5]
        );
        $shopTemplateCache =
            $this->getMockBuilder(ShopTemplateCacheServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $shopTemplateCache
            ->expects($this->once())
            ->method('invalidateCache')
            ->with($context->getCurrentShopId());

        $sut = $this->getSut(
            context: $context,
            shopTemplateCache: $shopTemplateCache
        );

        $sut->clearCurrentShopTemplateCache();
    }

    public function testClearCurrentShopInternalCache(): void
    {
        $context = $this->createConfiguredStub(
            ContextInterface::class,
            ['getCurrentShopId' => 3]
        );
        $shopAdapterInterface =
            $this->getMockBuilder(ShopAdapterInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
        $shopAdapterInterface
            ->expects($this->once())
            ->method('invalidateModulesCache');

        $sut = $this->getSut(
            context: $context,
            shopTemplateCache: null,
            shopAdapter: $shopAdapterInterface
        );

        $sut->clearCurrentShopInternalCache();
    }

    public function testClearCurrentShopContainerCache(): void
    {
        $context = $this->createConfiguredStub(
            ContextInterface::class,
            ['getCurrentShopId' => 2]
        );

        $containerCache =
            $this->getMockBuilder(ContainerCacheInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
        $containerCache
            ->expects($this->once())
            ->method('invalidate');

        $sut = $this->getSut(
            context: $context,
            shopTemplateCache: null,
            shopAdapter: null,
            containerCache: $containerCache
        );

        $sut->clearCurrentShopContainerCache();
    }

    public function testClearCurrentShopModuleCaches(): void
    {
        $shopId = random_int(1, 9999);
        $moduleIds = ['mod1', 'mod2', 'mod3'];

        $context = $this->createConfiguredStub(
            ContextInterface::class,
            ['getCurrentShopId' => $shopId]
        );

        $modulesDataProvider = $this->createConfiguredStub(
            ModulesDataProviderInterface::class,
            ['getModuleIds' => $moduleIds]
        );

        $captured = [];
        $moduleCacheService = $this->getMockBuilder(ModuleCacheServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $moduleCacheService->method('invalidate')
            ->willReturnCallback(function (string $moduleId, int $actualShopId) use (&$captured) {
                $captured[] = [$moduleId, $actualShopId];
            });

        $sut = $this->getSut(
            context: $context,
            shopTemplateCache: null,
            shopAdapter: null,
            containerCache: null,
            moduleCacheService: $moduleCacheService,
            modulesDataProvider: $modulesDataProvider
        );

        $sut->clearCurrentShopModuleCaches();

        $expected = array_map(fn(string $id) => [$id, $shopId], $moduleIds);
        $this->assertSame($expected, $captured);
    }

    public function testClearCurrentShopTemplateChainCache(): void
    {
        $shopId = random_int(1, 9999);
        $context = $this->createConfiguredStub(
            ContextInterface::class,
            ['getCurrentShopId' => $shopId]
        );

        $templateChainCache = $this->getMockBuilder(TemplateChainCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $templateChainCache
            ->expects($this->once())
            ->method('invalidate')
            ->with($shopId);

        $sut = $this->getSut(
            context: $context,
            templateChainCache: $templateChainCache
        );

        $sut->clearCurrentShopTemplateChainCache();
    }

    public function testClearAllCurrentShopCaches(): void
    {
        $sut = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'clearCurrentShopInternalCache',
                    'clearCurrentShopModuleCaches',
                    'clearCurrentShopTemplateCache',
                    'clearCurrentShopTemplateChainCache',
                    'clearCurrentShopContainerCache'
                ]
            )
            ->getMock();
        $sut->expects($this->once())
            ->method('clearCurrentShopInternalCache');
        $sut->expects($this->once())
            ->method('clearCurrentShopModuleCaches');
        $sut->expects($this->once())
            ->method('clearCurrentShopTemplateCache');
        $sut->expects($this->once())
            ->method('clearCurrentShopTemplateChainCache');
        $sut->expects($this->once())
            ->method('clearCurrentShopContainerCache');

        $sut->clearAllCurrentShopCaches();
    }

    private function getSut(
        ?ContextInterface $context = null,
        ?ShopTemplateCacheServiceInterface $shopTemplateCache = null,
        ?ShopAdapterInterface $shopAdapter = null,
        ?ContainerCacheInterface $containerCache = null,
        ?ModuleCacheServiceInterface $moduleCacheService = null,
        ?ModulesDataProviderInterface $modulesDataProvider = null,
        ?TemplateChainCacheInterface $templateChainCache = null
    ): Service {
        return new Service(
            context: $context ?? $this->createStub(ContextInterface::class),
            shopTemplateCache: $shopTemplateCache ??
                         $this->createStub(ShopTemplateCacheServiceInterface::class),
            shopAdapter: $shopAdapter ?? $this->createStub(ShopAdapterInterface::class),
            containerCache: $containerCache ?? $this->createStub(ContainerCacheInterface::class),
            moduleCacheService: $moduleCacheService ?? $this->createStub(ModuleCacheServiceInterface::class),
            modulesDataProvider: $modulesDataProvider ?? $this->createStub(ModulesDataProviderInterface::class),
            templateChainCache: $templateChainCache ?? $this->createStub(TemplateChainCacheInterface::class)
        );
    }
}
