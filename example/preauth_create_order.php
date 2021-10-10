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

/** Call ApiClient's getTransactionDetails method and return fake order confirmation url */
require(dirname(__FILE__) . '/init_example.php');

$client = new \BoltPay\ApiClient([
    'api_key' => \BoltPay\Bolt::$apiKey,
    'is_sandbox' => \BoltPay\Bolt::$isSandboxMode
]);

$requestJson = file_get_contents('php://input');
$requestData = json_decode($requestJson);
$baseUrl = $exampleData->getBaseUrl();
$response = [
    'status' => 'success',
    'message' => 'Order create was successful.',
    'order_received_url' => $baseUrl . '/example/order_confirmation.php',
    'display_id' => @$requestData->order->cart->display_id
];

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($response);


