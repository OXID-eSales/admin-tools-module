<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\CacheClear\Event;

use OxidEsales\EshopCommunity\Internal\Framework\Cache\Event\ClearShopCacheEvent;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class InvalidateGraphQLSchemaCacheEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly ?CacheInterface $graphqlCache = null)
    {
    }

    public function invalidateForShopCacheClear(ClearShopCacheEvent $event): void
    {
        $this->graphqlCache?->clear();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ClearShopCacheEvent::class => 'invalidateForShopCacheClear',
        ];
    }
}
