<?php

require(dirname(__FILE__) . '/ApiClient.php');
require(dirname(__FILE__) . '/Http/CurlClient.php');
require(dirname(__FILE__) . '/Http/Response.php');

$client = new \BoltPay\ApiClient([
    'api_key' => 'c117fec29f5c1365dacbc62390b5b6f98c0698a812d7015849319f9f7b863064',
    'is_sandbox' => true
]);

$res = $client->createOrder([cart => [
    order_reference => "212323",
    display_id => "abac",
    total_amount => 101,
    tax_amount => 1,
    currency => 'USD',
    items => [[
        name => 'foo',
        reference => '1r',
        total_amount => 100,
        unit_price => 100,
        quantity => 1
    ]]
]]);
echo $res->getStatusCode() . '\\n';
echo $res->getTraceId(). '\\n';
echo var_dump($res->getBody()). '\n';

