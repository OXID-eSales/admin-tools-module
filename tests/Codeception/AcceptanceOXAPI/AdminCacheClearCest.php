<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Codeception\AcceptanceOXAPI;

use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Codeception\Example;
use OxidEsales\AdminTools\Tests\Codeception\Support\AcceptanceTester;

#[Group('oe_admintools_oxapi')]
#[Group('oe_admintools_oxapi_cache')]
final class AdminCacheClearCest extends BaseCest
{
    #[DataProvider('cacheClearQueryDataProvider')]
    public function testCacheClearQueries(AcceptanceTester $I, Example $example): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runQuery(
            I:          $I,
            type: $example['type'],
            queryName:  $example['queryName'],
            parameters: $example['parameters'],
            field:      $example['field']
        );

        $I->assertArrayHasKey($example['queryName'], $result['data']);
    }
}
