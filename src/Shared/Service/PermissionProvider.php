<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Shared\Service;

final class PermissionProvider
{
    public function getPermissions(): array
    {
        return [
            'gqladmintoolscache' => [
                'CLEAR_CACHE'
            ],
        ];
    }
}
