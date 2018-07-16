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
     * @param array $additionalData
     * @return array
     */
    public function generateCart($additionalData = [])
    {
        $orderReference = 'or_' . time();

        $cart = [
            'cart' => [
                'order_reference' => $orderReference,
                'display_id' => "di_" . time(),
                'currency' => 'USD',
                'total_amount' => 10000,
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
                        'quantity' => 1
                    ],
                    [
                        'reference' => $orderReference,
                        'image_url' => '',
                        'name' => 'Sample Bolt product 2',
                        'sku' => 'BOLT-DEMO-SKU_2',
                        'description' => '',
                        'total_amount' => 10000,
                        'unit_price' => 20000,
                        'quantity' => 1
                    ]
                ]
            ]
        ];

        foreach ($additionalData as $key => $value) {
            $cart['cart'][$key] = $value;
        }

        // Correct data for row cartItem subtotal
        $subTotal = $this->getSubTotal($cart);
        $taxAmount = (int)(@$cart['cart']['tax_amount']);

        $discountAmount = 0;
        if (@$cart['cart']['discounts']) {

            foreach (@$cart['cart']['discounts'] as $key => $discountItem) {
                if (!array_key_exists('amount', $discountItem)) {
                    unset($cart['cart']['discounts'][$key]);
                    continue;
                }

                $discountAmount += $discountItem['amount'];
            }
        }

        //Total amount will be recalculated base on order subtotal, tax and discount.
        $calculatedGrandTotal = $subTotal + $taxAmount - $discountAmount;
        $cart['cart']['total_amount'] = $calculatedGrandTotal;

        return $cart;
    }


    /**
     * Get subtotal of cart
     * @param array $cart
     * @return float
     */
    public function getSubTotal(&$cart = [])
    {
        $subTotal = 0;

        if (@$cart['cart']['items']) {
            foreach (@$cart['cart']['items'] as $key => $cartItem) {

                if (
                    !array_key_exists('name', $cartItem) ||
                    !array_key_exists('total_amount', $cartItem) ||
                    !array_key_exists('unit_price', $cartItem) ||
                    !array_key_exists('quantity', $cartItem)
                ) {
                    unset($cart['cart']['items'][$key]);
                    continue;
                }

                $calculatedRowTotal = $cartItem['quantity'] * $cartItem['unit_price'];
                $cart['cart']['items'][$key]['total_amount'] = $calculatedRowTotal;

                $subTotal += $calculatedRowTotal;
            }
        }

        return $subTotal;
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
                    'tax_amount' => 0,
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
                    'tax_amount' => 0,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Express Saver',
                    'reference' => 'ups_WXS',
                    'cost' => 12192,
                    'tax_amount' => 0,
                ],
                [
                    'service' => 'United Parcel Service - Worldwide Express',
                    'reference' => 'ups_XPR',
                    'cost' => 12601,
                    'tax_amount' => 0,
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
    public function getPriceDisplay($amount, $currency)
    {
        return $amount . $currency;
    }

}