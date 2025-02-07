<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Shared\Service;

final class NamespaceMapper
{
    private const SPACE = '\\OxidEsales\\AdminTools\\';

    public function getControllerNamespaceMapping(): array
    {
        return [
            self::SPACE . 'CacheClear\\GraphQL' => __DIR__ . '/../../CacheClear/GraphQL/'
        ];
    }

    public function getTypeNamespaceMapping(): array
    {
        return [];
    }
}
