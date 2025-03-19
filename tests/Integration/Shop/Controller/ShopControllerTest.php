<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Integration\Shop\Controller;

use OxidEsales\AdminTools\CacheClear\Service\ServiceInterface;
use OxidEsales\AdminTools\CacheClear\Shop\Controller\ShopController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(ShopController::class)]
class ShopControllerTest extends IntegrationTestCase
{
    public function testRender(): void
    {
        $controller = new ShopController(
            $this->createStub(ServiceInterface::class),
            $this->createStub(LoggerInterface::class)
        );

        $this->assertSame('@oe_admintools/templates/admin_tools_cache', $controller->render());
    }

    #[DataProvider('cacheClearDataProvider')]
    public function testClearCache(int $post, string $method): void
    {
        $_POST[ShopController::ADMINTOOLS_CLEARCACHE_REQUESTPARAM] = $post;

        $service = $this->getMockBuilder(ServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $service->expects($this->once())
            ->method($method);

        $sut = new ShopController(
            $service,
            $this->createStub(LoggerInterface::class)
        );

        $sut->clearCache();
    }

    static public function cacheClearDataProvider(): \Generator
    {
        yield [
            'post' => 1,
            'method' => 'clearAllCurrentShopCaches'
        ];
        yield [
            'post' => 2,
            'method' => 'clearCurrentShopTemplateCache'
        ];
        yield [
            'post' => 3,
            'method' => 'clearCurrentShopInternalCache'
        ];
        yield [
            'post' => 4,
            'method' => 'clearCurrentShopContainerCache'
        ];
        yield [
            'post' => 5,
            'method' => 'clearCurrentShopModuleCaches'
        ];
    }

    #[DataProvider('cacheClearInvalidDataProvider')]
    public function testClearCacheInvalidRequest(int $post, string $method): void
    {
        $_POST[ShopController::ADMINTOOLS_CLEARCACHE_REQUESTPARAM] = $post;

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects($this->once())
            ->method($method);

        $sut = new ShopController(
            $this->createStub(ServiceInterface::class),
            $logger
        );

        $sut->clearCache();
    }

    static public function cacheClearInvalidDataProvider(): \Generator
    {
        yield [
            'post' => 0,
            'method' => 'warning'
        ];

        yield [
            'post' => 665,
            'method' => 'warning'
        ];
    }
}
