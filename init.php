<?php
require(dirname(__FILE__) . '/lib/ApiClient.php');
require(dirname(__FILE__) . '/lib/Http/CurlClient.php');
require(dirname(__FILE__) . '/lib/Http/Response.php');
require(dirname(__FILE__) . '/lib/SignatureVerifier.php');
require(dirname(__FILE__) . '/lib/Bolt.php');
require(dirname(__FILE__) . '/lib/Helper.php');
require(dirname(__FILE__) . '/example/Data.php');

// Bolt demo configuration
\BoltPay\Bolt::setApiKey('<api_key>');
\BoltPay\Bolt::setApiPublishableKey('<publishable_key>');
\BoltPay\Bolt::setSigningSecret('<signing_secret>');
\BoltPay\Bolt::setIsSandboxMode(true);
\BoltPay\Bolt::setAuthCapture(true);
