<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\CacheClear\GraphQL;

use OxidEsales\AdminTools\CacheClear\Service\ServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class Controller
{
    public function __construct(
        private ServiceInterface $cacheClearService
    ) {
    }

    #[Mutation]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearTemplateCache(): void
    {
        $this->cacheClearService->clearCurrentShopTemplateCache();
    }

    #[Mutation]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearInternalCache(): void
    {
        $this->cacheClearService->clearCurrentShopInternalCache();
    }

    #[Mutation]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearContainerCache(): void
    {
        $this->cacheClearService->clearCurrentShopContainerCache();
    }

    #[Mutation]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearModuleCaches(): void
    {
        $this->cacheClearService->clearCurrentShopModuleCaches();
    }

    #[Mutation]
    #[Logged]
    #[Right('CLEAR_CACHE')]
    public function clearCaches(): void
    {
        $this->cacheClearService->clearAllCurrentShopCaches();
    }
}
