<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */


namespace OxidEsales\AdminTools\Shop\Service;

use OxidEsales\GraphQL\Base\DataType\LoginInterface;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;

interface LoginServiceInterface
{
    public function token(EshopModelUser $user): LoginInterface;
    public function getExpirationTime(): int;
}