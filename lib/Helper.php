<?php

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