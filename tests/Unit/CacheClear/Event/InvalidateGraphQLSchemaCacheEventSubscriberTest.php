<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Unit\CacheClear\Event;

use OxidEsales\AdminTools\CacheClear\Event\InvalidateGraphQLSchemaCacheEventSubscriber;
use OxidEsales\EshopCommunity\Internal\Framework\Cache\Event\ClearShopCacheEvent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

#[CoversClass(InvalidateGraphQLSchemaCacheEventSubscriber::class)]
class InvalidateGraphQLSchemaCacheEventSubscriberTest extends TestCase
{
    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [ClearShopCacheEvent::class => 'invalidateForShopCacheClear'],
            InvalidateGraphQLSchemaCacheEventSubscriber::getSubscribedEvents()
        );
    }

    public function testInvalidateForShopCacheClearClearsGraphqlCache(): void
    {
        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache->expects($this->once())->method('clear');

        $sut = new InvalidateGraphQLSchemaCacheEventSubscriber($cache);

        $sut->invalidateForShopCacheClear(new ClearShopCacheEvent(random_int(1, 9999)));
    }

    public function testInvalidateForShopCacheClearNoopWhenGraphqlBaseInactive(): void
    {
        $sut = new InvalidateGraphQLSchemaCacheEventSubscriber(null);

        $sut->invalidateForShopCacheClear(new ClearShopCacheEvent(random_int(1, 9999)));

        $this->expectNotToPerformAssertions();
    }
}
