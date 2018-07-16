<?php

namespace BoltPay;

class Helper
{
    /**
     * Get the track javascript url, production or sandbox
     */
    public static function getTrackJsUrl()
    {
        return Bolt::$isSandboxMode ?
            Bolt::$connectSandboxBase . "/track.js" :
            Bolt::$connectProductionBase . "/track.js";
    }

    /**
     * Get the connect javascript url to production or sandbox
     */
    public static function getConnectJsUrl()
    {
        return Bolt::$isSandboxMode ?
            Bolt::$connectSandboxBase . "/connect.js" :
            Bolt::$connectProductionBase . "/connect.js";
    }

    /**
     * Get bolt url
     * @return string
     */
    public static function getApiUrl()
    {
        return Bolt::$isSandboxMode ? Bolt::$apiSandboxUrl : Bolt::$apiProductionUrl;
    }

}