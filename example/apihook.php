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
header('Content-Type: application/json');

if (@$requestData->type == 'discounts.code.apply') {
    $couponCode = @$requestData->discount_code;
    if ($couponCode == \BoltPay\Example\Data::VALID_COUPON) {

        $response = [
            'status' => 'success',
            'discount_code' => $couponCode,
            'discount_amount' => 1000,
            'description' => 'Discount (BOLT-DEMO)',
            'discount_type' => 'fixed_amount'
        ];

        http_response_code(200);
    } else {
        $error = new Exception("Coupon code is invalid");
        $response = [
            'status' => 'failure',
            'error' => [
                'code' => $error->getCode(),
                'message' => $error->getMessage(),
            ],
        ];

        http_response_code($error->getCode());
    }

}

if (@$requestData->type == "cart.create") {
    $orderReference = 'or_' . time();
    $cartData = [
        'cart' => [
            'order_reference' => $orderReference,
            'display_id' => "di_" . time(),
            'currency' => 'USD',
            'total_amount' => 10000 * $requestData->items[0]->quantity,
            'items' => [
                [
                    'reference' => $requestData->items[0]->reference,
                    'image_url' => '',
                    'name' => 'Sample Bolt product 1',
                    'sku' => 'BOLT-DEMO-SKU_1',
                    'description' => '',
                    'total_amount' => 10000 * $requestData->items[0]->quantity,
                    'unit_price' => 10000,
                    'quantity' => $requestData->items[0]->quantity,
                    'type' => 'physical'
                ],
            ]
        ]
    ];

    $client = new \BoltPay\ApiClient([
        'api_key' => \BoltPay\Bolt::$apiKey,
        'is_sandbox' => \BoltPay\Bolt::$isSandboxMode
    ]);

    $response = $client->createOrder($cartData);

    $response = [
        'status' => 'success',
        'cart' => $cartData['cart'],
    ];
}

echo json_encode($response);





