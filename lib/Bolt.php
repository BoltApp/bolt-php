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

class Bolt {
    public static $apiKey;

    public static $signingSecret;

    public static $apiPublishableKey;

    public static $apiPublishablePaymentOnlyKey;

    public static $connectSandboxBase = 'https://connect-sandbox.bolt.com';

    public static $connectProductionBase = 'https://connect.bolt.com';

    public static $apiSandboxUrl = 'https://api-sandbox.bolt.com';

    public static $apiProductionUrl = 'https://api.bolt.com';

    public static $isSandboxMode = true;

    public static $authCapture = false;
}
