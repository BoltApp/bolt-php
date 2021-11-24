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

require(dirname(__DIR__) . '/init.php');
require(dirname(__FILE__) . '/Data.php');
$config = require(dirname(__FILE__) . '/config.php');

// Set configuration data for example
\BoltPay\Bolt::$apiKey = @$config['API_KEY'];
\BoltPay\Bolt::$apiPublishableKey = @$config['PUBLISHABLE_KEY'];
\BoltPay\Bolt::$apiPublishablePaymentOnlyKey = @$config['PUBLISHABLE_KEY_PAYMENT_ONLY'];
\BoltPay\Bolt::$signingSecret = @$config['SIGNING_SECRET'];
\BoltPay\Bolt::$isSandboxMode = @$config['IS_SANDBOX'];
\BoltPay\Bolt::$authCapture = @$config['AUTH_CAPTURE'];
\BoltPay\Bolt::$connectSandboxBase = !@$config['CONNECT_SANDBOX_BASE'] ?: $config['CONNECT_SANDBOX_BASE'];
\BoltPay\Bolt::$connectProductionBase = !@$config['CONNECT_PRODUCTION_BASE'] ?: $config['CONNECT_PRODUCTION_BASE'];
\BoltPay\Bolt::$apiSandboxUrl = !@$config['API_SANDBOX_URL'] ?: $config['API_SANDBOX_URL'];
\BoltPay\Bolt::$apiProductionUrl = @$config['API_PRODUCTION_URL'] ?: $config['API_PRODUCTION_URL'];


