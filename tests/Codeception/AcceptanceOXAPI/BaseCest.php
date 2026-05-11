<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Tests\Codeception\AcceptanceOXAPI;

use OxidEsales\AdminTools\Tests\Codeception\Support\AcceptanceTester;

abstract class BaseCest
{
    private const ADMIN_USERNAME = 'noreply@oxid-esales.com';

    private const ADMIN_PASSWORD = 'admin';

    private const NOPERMISSIONADMIN_USERNAME = 'nopermission@oxid-esales.com';

    private const NOPERMISSIONADMIN_PASSWORD = 'admin';

    private const CUSTOMER_USERNAME = 'user@oxid-esales.com';

    private const CUSTOMER_PASSWORD = 'useruser';

    public function _after(AcceptanceTester $I): void
    {
        $I->logout();
    }

    protected function getCustomerUsername(): string
    {
        return self::CUSTOMER_USERNAME;
    }

    protected function getCustomerPassword(): string
    {
        return self::CUSTOMER_PASSWORD;
    }

    protected function getAdminUsername(): string
    {
        return self::ADMIN_USERNAME;
    }

    protected function getAdminPassword(): string
    {
        return self::ADMIN_PASSWORD;
    }

    protected function getNoPermissionAdminUsername(): string
    {
        return self::NOPERMISSIONADMIN_USERNAME;
    }

    protected function getNoPermissionAdminPassword(): string
    {
        return self::NOPERMISSIONADMIN_PASSWORD;
    }

    protected function runQuery(
        AcceptanceTester $I,
        string $type,
        string $queryName,
        array $parameters,
        string $field = ''
    ): array {
        $field = $field ? '{' . $field . '}' : '';
        $parameters = !empty($parameters) ? '(' . implode(',', $parameters) . ') ' : '';

        $query = $type . ' { ' .
            $queryName . $parameters .
            $field .
            '}';

        $I->sendGQLQuery($query);
        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    protected function cacheClearQueryDataProvider(): \Generator
    {
        yield [
            'type' => 'mutation',
            'queryName' => 'clearTemplateCache',
            'parameters' => [],
            'field' => ''
        ];
        yield [
            'type' => 'mutation',
            'queryName' => 'clearInternalCache',
            'parameters' => [],
            'field' => ''
        ];
        yield [
            'type' => 'mutation',
            'queryName' => 'clearContainerCache',
            'parameters' => [],
            'field' => ''
        ];
        yield [
            'type' => 'mutation',
            'queryName' => 'clearModuleCaches',
            'parameters' => [],
            'field' => ''
        ];
        yield [
            'type' => 'mutation',
            'queryName' => 'clearCaches',
            'parameters' => [],
            'field' => ''
        ];
    }
}
