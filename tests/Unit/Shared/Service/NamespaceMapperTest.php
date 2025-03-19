<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Unit\Tests\Unit\CacheClear\Shared\Service;

use OxidEsales\AdminTools\Shared\Service\NamespaceMapper;
use PHPUnit\Framework\TestCase;

class NamespaceMapperTest extends TestCase
{
    private const NAMESPACE_PREFIX = '\\OxidEsales\\AdminTools';

    private static string $srcPath;

    public static function setUpBeforeClass(): void
    {
        self::$srcPath = self::getSrcDirectoryPath();
    }

    public function testGetControllerNamespaceMapping(): void
    {
        $expectedMapping = [
            self::NAMESPACE_PREFIX . '\\CacheClear\\GraphQL' =>
                self::$srcPath . '/Shared/Service/../../CacheClear/GraphQL/'
        ];

        $sut = $this->getSut();
        $actualMapping = $sut->getControllerNamespaceMapping();

        $this->assertSame($expectedMapping, $actualMapping);
    }

    public function testGetTypeNamespaceMapping(): void
    {
        $expectedMapping = [];

        $sut = $this->getSut();
        $actualMapping = $sut->getTypeNamespaceMapping();

        $this->assertSame($expectedMapping, $actualMapping);
    }

    private static function getSrcDirectoryPath(): string
    {
        $testsDir = 'tests';
        $currentPath = __DIR__;
        $testsPos = strpos($currentPath, $testsDir);

        if ($testsPos === false) {
            return $currentPath;
        }

        return substr($currentPath, 0, $testsPos) . 'src';
    }

    private function getSut(): NamespaceMapper
    {
        return new NamespaceMapper();
    }
}
