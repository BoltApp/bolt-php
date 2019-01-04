<?php
/**
 * Bolt PHP library
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License (MIT)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category   Bolt
 * @copyright  Copyright (c) 2018 Bolt Financial, Inc (https://www.bolt.com)
 * @license    https://opensource.org/licenses/MIT  MIT License (MIT)
 */

// Composer autoloader path
$vendorAutoload = dirname(dirname(__DIR__)) . '/autoload.php';

if (file_exists($vendorAutoload)) {
    // Load classes via composer autoloader
    require($vendorAutoload);
} else {
    // Preload library classes
    require(dirname(__FILE__) . '/lib/ApiClient.php');
    require(dirname(__FILE__) . '/lib/Http/CurlClient.php');
    require(dirname(__FILE__) . '/lib/Http/Response.php');
    require(dirname(__FILE__) . '/lib/SignatureVerifier.php');
    require(dirname(__FILE__) . '/lib/Bolt.php');
    require(dirname(__FILE__) . '/lib/Helper.php');
}
