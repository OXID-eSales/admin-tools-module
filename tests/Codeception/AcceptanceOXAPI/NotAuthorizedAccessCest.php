<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Codeception\AcceptanceOXAPI;

use Codeception\Attribute\Group;
use Codeception\Example;
use Codeception\Attribute\DataProvider;
use OxidEsales\AdminTools\Tests\Codeception\Support\AcceptanceTester;

#[Group('oe_admintools_oxapi')]
#[Group('oe_admintools_oxapi_authorization')]
final class NotAuthorizedAccessCest extends BaseCest
{
    #[DataProvider('cacheClearQueryDataProvider')]
    public function testNotAuthorizedQueries(AcceptanceTester $I, Example $example): void
    {
        $I->login($this->getCustomerUsername(), $this->getCustomerPassword());

        $result = $this->runQuery(
            I:          $I,
            type: $example['type'],
            queryName:  $example['queryName'],
            parameters: $example['parameters'],
            field:      $example['field']
        );

        $this->assertQueryNotFoundErrorInResult($I, $result);
    }

    #[DataProvider('cacheClearQueryDataProvider')]
    public function testNoPermissionQueries(AcceptanceTester $I, Example $example): void
    {
        $I->login($this->getNoPermissionAdminUsername(), $this->getNoPermissionAdminPassword());

        $result = $this->runQuery(
            I:          $I,
            type: $example['type'],
            queryName:  $example['queryName'],
            parameters: $example['parameters'],
            field:      $example['field']
        );

        $this->assertQueryNotFoundErrorInResult($I, $result);
    }



    protected function assertQueryNotFoundErrorInResult(AcceptanceTester $I, array $result): void
    {
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame(
            'You do not have sufficient rights to access this field',
            $errorMessage
        );
    }
}
