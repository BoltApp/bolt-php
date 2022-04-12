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
$hmacHeader = @$_SERVER['HTTP_X_BOLT_HMAC_SHA256'];

$signatureVerifier = new \BoltPay\SignatureVerifier(
    \BoltPay\Bolt::$signingSecret
);

$requestJson = file_get_contents('php://input');
$exampleData = new \BoltPay\Example\Data();
$cartPageURL = $exampleData->getBaseUrl().'/example/cart.php';

$_SESSION['logged_in'] = true;
header('Content-Type: application/json');
http_response_code(200);
header("Location:$cartPageURL");
