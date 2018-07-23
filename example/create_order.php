<?php
/** Call ApiClient's getTransactionDetails method and return fake order confirmation url */
require(dirname(__FILE__) . '/init_example.php');

$client = new \BoltPay\ApiClient([
    'api_key' => \BoltPay\Bolt::$apiKey,
    'is_sandbox' => \BoltPay\Bolt::$isSandboxMode
]);

$requestJson = file_get_contents('php://input');
$requestData = json_decode($requestJson);

$result = $client->getTransactionDetails(@$requestData->reference);

$response = [
    'confirmation_url' => 'order_confirmation.php',
    'transaction_detail' => $result->getBody()
];

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($response);


