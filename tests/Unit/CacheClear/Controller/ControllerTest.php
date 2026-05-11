<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Unit\CacheClear\Controller;

use OxidEsales\AdminTools\CacheClear\Service\ServiceInterface;
use OxidEsales\AdminTools\CacheClear\GraphQL\Controller;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Controller::class)]
class ControllerTest extends TestCase
{
    #[DataProvider('cacheClearDataProvider')]
    public function testCacheClear(array $expected, string $method): void
    {
        $serviceMock = $this->getMockBuilder(ServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        foreach ($expected as $called) {
            $serviceMock
                ->expects($this->once())
                ->method($called);
        }

        $sut = $this->getSut($serviceMock);

        $sut->$method();
    }

    static public function cacheClearDataProvider(): \Generator
    {
        yield [
            'expected' => [
                'clearCurrentShopTemplateCache'
            ],
            'method' => 'clearTemplateCache'
        ];
        yield [
            'expected' => [
                'clearCurrentShopInternalCache'
            ],
            'method' => 'clearInternalCache'
        ];
        yield [
            'expected' => [
                'clearCurrentShopContainerCache'
            ],
            'method' => 'clearContainerCache'
        ];
        yield [
            'expected' => [
                'clearCurrentShopModuleCaches'
            ],
            'method' => 'clearModuleCaches'
        ];
        yield [
            'expected' => [
                'clearCurrentShopTemplateChainCache'
            ],
            'method' => 'clearTemplateChainCache'
        ];
        yield [
            'expected' => [
                'clearCurrentShopGraphQLSchemaCache'
            ],
            'method' => 'clearGraphQLSchemaCache'
        ];
        yield [
            'expected' => [
                'clearAllCurrentShopCaches'
            ],
            'method' => 'clearCaches'
        ];
    }

    private function getSut(
        ?ServiceInterface $service = null
    ): Controller {
        return new Controller(
            cacheClearService: $service ?? $this->createStub(ServiceInterface::class)
        );
    }
}
