<?php

namespace BoltPay\Example;

/**
 * Class Data for generate dummy data
 * @package BoltPay\Example
 */
class Data
{
    /**
     * Get dummy customer data
     * @return array
     */
    public function generateCart() {
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
     * Get dummy shipping options
     * @return array
     */
    public function generateShippingOptions() {
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
     * Get price display data
     * @param $amount
     * @param $currency
     * @return string
     */
    public function getPriceDisplay($amount, $currency) {
        return $amount . $currency;
    }

    /**
     * Get auth capture config for javascript variable
     * @return string
     */
    public function getAuthCaptureConfig() {
       return json_encode(\BoltPay\Bolt::$authCapture);
    }

}