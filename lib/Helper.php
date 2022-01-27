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

namespace BoltPay;

class Helper {
    /**
     * Get the track javascript url, production or sandbox
     */
    public static function getTrackJsUrl() {
        return Bolt::$isSandboxMode ?
            Bolt::$connectSandboxBase . "/track.js" :
            Bolt::$connectProductionBase . "/track.js";
    }

    /**
     * Get the connect javascript url to production or sandbox
     */
    public static function getConnectJsUrl() {
        return Bolt::$isSandboxMode ?
            Bolt::$connectSandboxBase . "/connect.js" :
            Bolt::$connectProductionBase . "/connect.js";
    }

    public static function getPayByLinkUrl() {
        return Bolt::$isSandboxMode ?
            Bolt::$connectSandboxBase . "/checkout" :
            Bolt::$connectProductionBase . "/checkout";
    }

    /**
     * Get bolt url
     * @return string
     */
    public static function getApiUrl() {
        return Bolt::$isSandboxMode ? Bolt::$apiSandboxUrl : Bolt::$apiProductionUrl;
    }

    /**
     * Get script tag for track js url
     * @param $paymentOnlyKey
     * @return string
     */
    public static function renderBoltTrackScriptTag($paymentOnlyKey = false) {
        $publishableKey = $paymentOnlyKey ? \BoltPay\Bolt::$apiPublishablePaymentOnlyKey : \BoltPay\Bolt::$apiPublishableKey;
        return ' <script
                        id="bolt-track"
                        type="text/javascript"
                        src="' . self::getTrackJsUrl() . '"
                        data-publishable-key="' . $publishableKey . '">
                </script>';
    }

    /**
     * Get script tag for bolt connect js url
     * @param $paymentOnlyKey
     * @return string
     */
    public static function renderBoltConnectScriptTag($paymentOnlyKey = false) {
        $publishableKey = $paymentOnlyKey ? \BoltPay\Bolt::$apiPublishablePaymentOnlyKey : \BoltPay\Bolt::$apiPublishableKey;
        return '<script
                        id="bolt-connect"
                        type="text/javascript"
                        src="' . self::getConnectJsUrl() . '"
                        data-publishable-key="' . $publishableKey . '">
                </script>';
    }



}
