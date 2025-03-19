<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Unit\Tests\Unit\CacheClear\Shared\Service;

use PHPUnit\Framework\TestCase;
use OxidEsales\AdminTools\Shared\Service\PermissionProvider;

class PermissionProviderTest extends TestCase
{
    public function testGetPermissions(): void
    {
        $expectedPermissions = [
            'gqladmintoolscache' => [
                'CLEAR_CACHE'
            ],
        ];

        $permissionProvider = new PermissionProvider();
        $actualPermissions = $permissionProvider->getPermissions();

        $this->assertSame($expectedPermissions, $actualPermissions);
    }
}
