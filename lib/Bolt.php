<?php

namespace BoltPay;

class Bolt {
    public static $apiKey;

    public static $signingSecret;

    public static $apiPublishableKey;

    public static $connectSandboxBase = 'https://connect-sandbox.bolt.com';

    public static $connectProductionBase = 'https://connect.bolt.com';

    public static $apiSandboxUrl = 'https://api-sandbox.bolt.com';

    public static $apiProductionUrl = 'https://api.bolt.com';

    public static $isSandboxMode = true;

    public static $authCapture = false;
}