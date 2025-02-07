<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\CacheClear\GraphQL;

use OxidEsales\AdminTools\CacheClear\Service\ServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class Controller
{
    public function __construct(
        private ServiceInterface $cacheClearService
    ) {
    }

    #[Query]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearTemplateCache(): void
    {
        $this->cacheClearService->clearCurrentShopTemplateCache();
    }

    #[Query]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearInternalCache(): void
    {
        $this->cacheClearService->clearCurrentShopInternalCache();
    }

    #[Query]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearContainerCache(): void
    {
        $this->cacheClearService->clearCurrentShopContainerCache();
    }

    #[Query]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearModuleCaches(): void
    {
        $this->cacheClearService->clearCurrentShopModuleCaches();
    }

    #[Query]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearCaches(): void
    {
        $this->cacheClearService->clearAllCurrentShopCaches();
    }
}
