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

/** Return hardcoded response based on event type. */
require(dirname(__FILE__) . '/init_example.php');

$hmacHeader = @$_SERVER['HTTP_X_BOLT_HMAC_SHA256'];

$signatureVerifier = new \BoltPay\SignatureVerifier(
    \BoltPay\Bolt::$signingSecret
);

$requestJson = file_get_contents('php://input');

if (!$signatureVerifier->verifySignature($requestJson, $hmacHeader)) {
    throw new Exception("Failed HMAC Authentication");
}

$requestData = json_decode($requestJson);
$event = $requestData->event;

header('Content-Type: application/json');
http_response_code(200);
$exampleData = new \BoltPay\Example\Data();
switch ($event) {
    case "order.shipping":
        $data = $exampleData->generateShippingOptions();
        break;
    case "order.tax":
        $shippingOption = @$requestData->data->shipping_option;
        $data = $exampleData->generateTaxOptions($shippingOption);
        break;
    case "order.shipping_and_tax":
        $data = $exampleData->generateShippingTaxOptions();
        break;
    case "order.create":
        $baseUrl = $exampleData->getBaseUrl();
        $data = [
            'status' => 'success',
            'message' => 'Order create was successful.',
            'order_received_url' => $baseUrl . '/example/order_confirmation.php',
            'display_id' => @$requestData->order->cart->display_id
        ];
        break;
}

echo json_encode(
    [
        'status' => 'success',
        'event' => $event,
        'data' => $data,
    ]
);


