<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Shop\Extension;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Core\Di\ContainerFacade;
use OxidEsales\AdminTools\Shop\Service\LoginServiceInterface;

class User extends User_parent
{
    private const JWT_COOKIE_NAME = 'oxapi_jwt';
    private const REFRESH_COOKIE_NAME = 'oxapi_refresh';

    public function login($userName, $password, $setSessionCookie = false)
    {
        $result = parent::login($userName, $password);

        $loginService = ContainerFacade::get(LoginServiceInterface::class);
        $loginType = $loginService
            ->token($this);

//        $exp = $loginType->accessToken()->claims()->get('exp')->getTimestamp();
        //TODO: check secure flag for cookies, note that httponly is shop default, secure is not
        Registry::getUtilsServer()->setOxCookie(static::JWT_COOKIE_NAME, $loginType->accessToken(), $loginService->getExpirationTime());
        Registry::getUtilsServer()->setOxCookie(static::REFRESH_COOKIE_NAME, $loginType->refreshToken());

        return $result;
    }

    public function logout()
    {
        Registry::getUtilsServer()->deleteUserCookie(static::JWT_COOKIE_NAME);
        Registry::getUtilsServer()->deleteUserCookie(static::REFRESH_COOKIE_NAME);

        parent::logout();
    }
}