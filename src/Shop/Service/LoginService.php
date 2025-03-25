<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Shop\Service;

use OxidEsales\GraphQL\Base\Service\RefreshTokenServiceInterface;
use OxidEsales\GraphQL\Base\Service\Token;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\GraphQL\Base\DataType\User as UserDataType;
use OxidEsales\GraphQL\Base\DataType\LoginInterface;
use OxidEsales\GraphQL\Base\DataType\Login as LoginDataType;

final class LoginService implements LoginServiceInterface
{
    private $jwtExpTime = null;

    public function __construct(
        protected Token $tokenService,
        protected RefreshTokenServiceInterface $refreshTokenService
    )
    {
    }

    public function token(EshopModelUser $user): LoginInterface
    {
        $userType = new UserDataType($user);

        $accesstoken = $this->tokenService->createTokenForUser($userType);
        $this->jwtExpTime = $accesstoken->claims()->get('exp')->getTimestamp();

        return new LoginDataType(
            $this->refreshTokenService->createRefreshTokenForUser($userType),
            $accesstoken
        );
    }

    public function getExpirationTime(): int
    {
        return $this->jwtExpTime ?: time();
    }
}