<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\CacheClear\Shop\Controller;

use OxidEsales\AdminTools\CacheClear\Service\ServiceInterface;
use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Core\Registry;
use Psr\Log\LoggerInterface;

class ShopController extends AdminController
{
    public const ADMINTOOLS_CLEARCACHE_REQUESTPARAM = 'clear';

    /**
     * @var string
     */
    protected $_sThisTemplate = '@oe_admintools/templates/admin_tools_cache';

    public function __construct(
        private readonly ServiceInterface $service,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct();
    }

    public function render()
    {
        return parent::render();
    }

    public function clearCache(): void
    {
        $clear = (int) Registry::getRequest()->getRequestEscapedParameter(self::ADMINTOOLS_CLEARCACHE_REQUESTPARAM);

        match ($clear) {
            1 => $this->service->clearAllCurrentShopCaches(),
            2 => $this->service->clearCurrentShopTemplateCache(),
            3 => $this->service->clearCurrentShopInternalCache(),
            4 => $this->service->clearCurrentShopContainerCache(),
            5 => $this->service->clearCurrentShopModuleCaches(),
            default => $this->logger->warning('Unmatched cache clear request input.')
        };
    }
}
