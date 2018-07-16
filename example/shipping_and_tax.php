<?php
/** Return hardcoded shipping methods. */
require('../init.php');

$hmacHeader = @$_SERVER['HTTP_X_BOLT_HMAC_SHA256'];

$signatureVerifier = new \BoltPay\SignatureVerifier(
    \BoltPay\Bolt::getSigningSecret()
);

$requestJson = file_get_contents('php://input');

if (!$signatureVerifier->verifyHook($requestJson, $hmacHeader)) {
    throw new Exception("Failed HMAC Authentication");
}

$exampleData = new \BoltPay\Example\Data();

$response = $exampleData->generateShippingOptions();

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($response);


