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

/** Return hardcoded shipping methods. */

require(dirname(__FILE__) . '/../init_example.php');
session_start();
$_SESSION['logged_in'] = false;
$exampleData = new \BoltPay\Example\Data();
$cartPageURL = $exampleData->getBaseUrl().'/example/cart.php';
header("Location:$cartPageURL");