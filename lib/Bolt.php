<?php

namespace BoltPay;

class Bolt
{

    public static $apiKey;

    public static $signingSecret;

    public static $apiPublishableKey;

    public static $connectSandboxBase = 'https://connect-sandbox.bolt.com';

    public static $connectProductionBase = 'https://connect.bolt.com';

    public static $apiSandboxUrl = 'https://api-sandbox.bolt.com';

    public static $apiProductionUrl = 'https://api.bolt.com';

    public static $isSandboxMode = true;

    public static $authCapture = true;

    /**
     * @return mixed
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public static function getApiPublishableKey()
    {
        return self::$apiPublishableKey;
    }

    /**
     * @param mixed $apiPublishableKey
     */
    public static function setApiPublishableKey($apiPublishableKey)
    {
        self::$apiPublishableKey = $apiPublishableKey;
    }

    /**
     * @return string
     */
    public static function getConnectSandboxBase()
    {
        return self::$connectSandboxBase;
    }

    /**
     * @param string $connectSandboxBase
     */
    public static function setConnectSandboxBase(string $connectSandboxBase)
    {
        self::$connectSandboxBase = $connectSandboxBase;
    }

    /**
     * @return string
     */
    public static function getConnectProductionBase()
    {
        return self::$connectProductionBase;
    }

    /**
     * @param string $connectProductionBase
     */
    public static function setConnectProductionBase($connectProductionBase)
    {
        self::$connectProductionBase = $connectProductionBase;
    }

    /**
     * @return bool
     */
    public static function isSandboxMode()
    {
        return self::$isSandboxMode;
    }

    /**
     * @param bool $isSandboxMode
     */
    public static function setIsSandboxMode($isSandboxMode)
    {
        self::$isSandboxMode = $isSandboxMode;
    }

    /**
     * @return mixed
     */
    public static function getAuthCapture()
    {
        return self::$authCapture;
    }

    /**
     * @param mixed $authCapture
     */
    public static function setAuthCapture($authCapture)
    {
        self::$authCapture = $authCapture;
    }

    /**
     * @return mixed
     */
    public static function getSigningSecret()
    {
        return self::$signingSecret;
    }

    /**
     * @param mixed $signingSecret
     */
    public static function setSigningSecret($signingSecret)
    {
        self::$signingSecret = $signingSecret;
    }


}