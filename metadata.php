<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'          => 'oe_admintools',
    'title'       => 'OxidEsales Admin Tools',
    'description' =>  '',
    'thumbnail'   => 'pictures/logo.png',
    'version'     => '1.0.0',
    'author'      => 'OXID eSales AG',
    'url'         => '',
    'email'       => '',
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\User::class => \OxidEsales\AdminTools\Shop\Extension\User::class
    ],
    'controllers' => [],
    'events'      => [],
    'settings'    => [],
];
