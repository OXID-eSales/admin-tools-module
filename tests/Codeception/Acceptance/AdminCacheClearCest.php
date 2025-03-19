<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Codeception\Acceptance;

use Codeception\Attribute\Group;
use OxidEsales\AdminTools\Tests\Codeception\Support\AcceptanceTester;
use OxidEsales\Codeception\Module\Translation\Translator;

#[Group('oe_admintools')]
#[Group('oe_admintools_cache')]
final class AdminCacheClearCest
{
    public function testTriggerCacheClear(AcceptanceTester $I): void
    {
        $I->wantToTest('trigger cache clear via admin');

        $I->clearShopCache();
        $I->loginAdmin();

        $I->selectHeaderFrame();
        $I->see(Translator::translate('CLEARCACHE_ALL'));
        $I->click(Translator::translate('CLEARCACHE_SUBMIT'));
        $I->waitForText(Translator::translate('CLEARCACHE_TRIGGERED'));
    }
}
