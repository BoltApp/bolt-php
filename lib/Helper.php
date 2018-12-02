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

    /**
     * Get bolt url
     * @return string
     */
    public static function getApiUrl() {
        return Bolt::$isSandboxMode ? Bolt::$apiSandboxUrl : Bolt::$apiProductionUrl;
    }

    /**
     * Get script tag for track js url
     * @return string
     */
    public static function renderBoltTrackScriptTag() {
        return ' <script
                        id="bolt-track"
                        type="text/javascript"
                        src="' . self::getTrackJsUrl() . '"
                        data-publishable-key="' . \BoltPay\Bolt::$apiPublishableKey . '">
                </script>';
    }

    /**
     * Get script tag for bolt connect js url
     * @return string
     */
    public static function renderBoltConnectScriptTag() {
        return '<script
                        id="bolt-connect"
                        type="text/javascript"
                        src="' . self::getConnectJsUrl() . '"
                        data-publishable-key="' . \BoltPay\Bolt::$apiPublishableKey . '">
                </script>';
    }

}
