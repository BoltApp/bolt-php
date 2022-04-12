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

namespace BoltPay\Example;

/**
 * Class Data for generate dummy data
 * @package BoltPay\Example
 */
class Data
{
    const VALID_COUPON = 'BOLT-DEMO';
    /**
     * Get dummy customer data
     * @return array
     */
    public function generateCart()
    {
        $orderReference = 'or_' . time();

        $cart = [
            'cart' => [
                'order_reference' => $orderReference,
                'display_id' => "di_" . time(),
                'currency' => 'USD',
                'total_amount' => 29000,
                'tax_amount' => 0,
                'discounts' => [
                    [
                        'amount' => 1000,
                        'description' => 'Discount (BOLT-DEMO)',
                        'type' => 'fixed_amount'
                    ]
                ],
                'items' => [
                    [
                        'reference' => $orderReference,
                        'image_url' => '',
                        'name' => 'Sample Bolt product 1',
                        'sku' => 'BOLT-DEMO-SKU_1',
                        'description' => '',
                        'total_amount' => 10000,
                        'unit_price' => 10000,
                        'quantity' => 1,
                        'type' => 'physical'
                    ],
                    [
                        'reference' => $orderReference,
                        'image_url' => '',
                        'name' => 'Sample Bolt product 2',
                        'sku' => 'BOLT-DEMO-SKU_2',
                        'description' => '',
                        'total_amount' => 20000,
                        'unit_price' => 20000,
                        'quantity' => 1,
                        'type' => 'digital'
                    ]
                ]
            ]
        ];

        return $cart;
    }

    /**
     * @return array
     */
    public function getOAuthConfiguration() {
        $publishableKey = \BoltPay\Bolt::$apiPublishableKey;
        $publishableKeySplit = explode('.', $publishableKey);
        $clientID = end($publishableKeySplit);
        $clientSecret = \BoltPay\Bolt::$signingSecret;

        $boltPublicKey = $this->getPublicKey();

        return [$clientID, $clientSecret, $boltPublicKey];
    }

    /**
     * @param $code
     * @param $scope
     * @param $clientId
     * @param $clientSecret
     * @return \BoltPay\Http\Response|string
     */
    public function exchangeToken($code, $scope, $clientId, $clientSecret)
    {
        try {
            $ch = curl_init();
            $contentLength = 0;

            $headers = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: ' . $contentLength,
                'X-Api-Key: ' . \BoltPay\Bolt::$apiKey,
                'X-Nonce: ' . rand(100000000, 999999999),
                'User-Agent: BoltPay/PHP-Client-0.1'
            );
            $baseURL = \BoltPay\Bolt::$isSandboxMode ? \BoltPay\Bolt::$apiSandboxUrl . '/v1/' : \BoltPay\Bolt::$apiProductionUrl . '/v1/';
            curl_setopt($ch, CURLOPT_URL, $baseURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code={$code}&scope={$scope}&client_id={$clientId}&client_secret={$clientSecret}");

            $rawResponse = curl_exec($ch);

            if ($rawResponse === false) { // Timeout
                curl_close($ch);
                return new Response(0, "{}", 0);
            }

            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            curl_close($ch);

            $chHeaders = substr($rawResponse, 0, $headerSize);
            $body = json_decode(substr($rawResponse, $headerSize));

            $boltTraceId = '';
            foreach(explode("\r\n", $chHeaders) as $row) {
                if(preg_match('/(.*?): (.*)/', $row, $matches)) {
                    if(count($matches) == 3 && $matches[1] == 'X-Bolt-Trace-Id') {
                        $boltTraceId = $matches[2];
                        break;
                    }
                }
            }
            $response = new \BoltPay\Http\Response($statusCode, $body ?: [], $boltTraceId);

            return empty($response) ? 'empty response' : $response;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return \BoltPay\Bolt::$isSandboxMode ?
            'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAumrI98nQ0thJELhOa0AI4fQkEEuh9gHOFEQUjVZzSZO/O5x42mugJyMq3hDGwJBOH2FUgT5WnGt9tHJ9NbTwfZtljOyRkmoTUGFkQIcRZy/b0fD9/IfFXuAXJebflCIVFO/UnFRN4Z9RQqx+vffAE+qNnQV/V/455Qw0+/HW5n06Df0UVYXiZ1+2RXfGIinPcUgMS59r12kJDahELTWWcwa1gJE1UnSUiwTO7dDp1IjgGml6cpbynYcROyuz4wNumIj7w6tH+krmPguTYXPmKVSmZtqFCh1reXonSZBQ9XvuWhQbY3skf7X2AELHB6nkUNaUlVlSbG/DiHjxSAvSr3HSKLHiaYuB3VA/FWgfSWvg9kZVE9d1Qg+JhYL8kIxcWIgH37onIR5gh7lep0u73WlgFy97tjy9uiTmcjrzBBXtxl5PsLGaTJGPkZnAON4BH0Njuq23G/ZHXcJvX8uFs4VlfItq838SjJqzCrWS5eK4mKX669dYEXenjv8mqqkKSD3PNZl4ixwfMkhmVAeYA0qPnq5rt7XA5mVlr5BNkpal29fL/s6CcdfAylzvzS3C1a6z3ZpZSl2yGAfDgceC4+h+iLJmyeZM3Jz1jttE9BTUxwlhQvO/xIDkJXGgU9y8TMy/rNcPS/qOW1k4DDcTM/eCqsISa58WWiCO0WQUW6ECAwEAAQ=='
            : 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAsfwvIFA3rstwsFizP9Yyjq8okQZFFZoxjORzdapQdf8UDQ/1hVTi26epvRKcKg0Zwxq6s/m1TWXsWJjIpAPWFVABcUufHnxgwXWyHsCedEmaJzomgoehMB/Ul4hNVfj0Dt7eNjsa2EboJ41B5Ir7MZ4LR1PRs2vlGQN73cEUQSrd0vtYPV69DXABk/o4fW+qU9iyWoCfJdhMWon32edMGnz6qxg0mFlOP0NTkkZPS3MbIoIxuhYT5/E35WoL60eSVjdPxYc4qeEK1+mOSKtjDku3mEsz5R3G20xUhK8lxSRqIIPbRyg9Y8Cg5LkXTsBDSGZX445bXsfeR9RigVblqLPFNQVcXyBV2CQe/bBwaLGxrNSXWUCWP+ITu+QVWAJ+HXMfyWDuPI0gVrlyC6BIEq6i4nC4UGZjs0MkU3mHTI2oojg6m0uDJvuwtxUq4mPdMhxXfnr8NJWvG2vzVQ+wds//9663VHbnCXi87PqtSaFbLFVUYNoJdDINQRtpnZNFxebH524k6dM9dZnA6rTdUwSoXbzE5HL64sUY6HCnNkqRS0HiwQBuz6WxDh7wuocxcXuAIwpYD3IYf1HKF1vyGtdHbLn7GhhDuelEzN3JgPdntrNp6tuLGJb47tO1KVz+/ps4e97colDjQAP7R8halVYUIGQ3rjwhZJXQP1suU0kCAwEAAQ==';
    }
    public function generateCartPaymentOnly()
    {
        $cart = $this->generateCart();
        $cart['cart']['shipments'] = [
            [
                'cost' => 2000,
                'shipping_address' => [
                    'first_name' => 'Bolt',
                    'last_name' => 'Bolt',
                    'company' => 'BOLT company',
                    'phone' => '8888888888',
                    'street_address1' => '4535 ANNALEE Way',
                    'locality' => 'Knoxville',
                    'region' => 'Tennessee',
                    'postal_code' => '37921',
                    'country_code' => 'US',
                    'email' => 'test@bolt.com'
                ],
                'service' => 'Sample Bolt Shipping',
                'reference' => 'bolt_shipping',
                ]
        ];
        $cart['cart']['tax_amount'] = 3000;
        $cart['cart']['total_amount'] += $cart['cart']['tax_amount'] + $cart['cart']['shipments'][0]['cost'];
        return $cart;
    }

    /**
     * Get dummy shipping and tax options
     * @return array
     */
    public function generateShippingTaxOptions()
    {
        return [
            'shipping_options' => [
                [
                    'service' => 'Flat Rate - Fixed',
                    'reference' => 'flatrate_flatrate',
                    'cost' => 800,
                    'tax_amount' => 200,
                ],
                [
                    'service' => 'Free Shipping - Free',
                    'reference' => 'freeshipping_freeshipping',
                    'cost' => 0,
                    'tax_amount' => 0,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Expedited',
                    'reference' => 'ups_XPD',
                    'cost' => 11479,
                    'tax_amount' => 1543,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Express Saver',
                    'reference' => 'ups_WXS',
                    'cost' => 12192,
                    'tax_amount' => 1531,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Express',
                    'reference' => 'ups_XPR',
                    'cost' => 12601,
                    'tax_amount' => 3230,
                ],
            ],
            'tax_result' => [
                'amount' => 0,
            ],
        ];
    }

    /**
     * Get dummy shipping options
     * @return array
     */
    public function generateShippingOptions()
    {
        return [
            'shipping_options' => [
                [
                    'service' => 'Flat Rate - Fixed',
                    'reference' => 'flatrate_flatrate',
                    'cost' => 800,
                ],
                [
                    'service' => 'Free Shipping - Free',
                    'reference' => 'freeshipping_freeshipping',
                    'cost' => 0,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Expedited',
                    'reference' => 'ups_XPD',
                    'cost' => 11479,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Express Saver',
                    'reference' => 'ups_WXS',
                    'cost' => 12192,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Express',
                    'reference' => 'ups_XPR',
                    'cost' => 12601,
                ],
            ],
        ];
    }

    /**
     * @param $shippingOption
     * @return array
     */
    public function generateTaxOptions($shippingOption)
    {
        $taxAmount = 1500;
        return [
            'shipping_option' => [
                'service' => $shippingOption->service,
                'reference' => $shippingOption->reference,
                'cost' => $shippingOption->cost,
                'tax_amount' => $taxAmount,
            ],
        ];
    }

    /**
     * Get price display data
     * @param $amount
     * @param $currency
     * @return string
     */
    public function getPriceDisplay($amount, $currency)
    {
        return $amount . $currency;
    }

    /**
     * Get auth capture config for javascript variable
     * @return string
     */
    public function getAuthCaptureConfig()
    {
        return json_encode(\BoltPay\Bolt::$authCapture);
    }

    /**
     * Get base url
     * @return string
     */
    public function getBaseUrl()
    {
        $hostName = $_SERVER['HTTP_HOST'];
        $protocol = strtolower(substr($_SERVER["REQUEST_SCHEME"], 0, 5)) == 'https://' ? 'https://' : 'http://';
        return $protocol . $hostName;
    }

}
