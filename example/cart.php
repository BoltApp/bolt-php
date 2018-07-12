<?php

require(dirname(dirname(__FILE__)) . '/lib/ApiClient.php');
require(dirname(dirname(__FILE__)) . '/lib/Http/CurlClient.php');
require(dirname(dirname(__FILE__)) . '/lib/Http/Response.php');

$client = new \BoltPay\ApiClient([
    'api_key' => '52d1a4b1cd2d27da26de1240da6504da1ea78cd8f1d103145da717217cc71541',
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
?>

<html>
<head>
  <title>Bolt php library demo</title>
  
</head>
<body>

<?php
  echo $res->getStatusCode();
?>

</body>
</html>