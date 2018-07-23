<?php
/** Render valid HTML with bolt checkout button */
require(dirname(__FILE__) . '/init_example.php');

$successUrl = 'order_confirmation.php';
$saveOrderUrl = 'create_order.php';

$client = new \BoltPay\ApiClient([
    'api_key' => \BoltPay\Bolt::$apiKey,
    'is_sandbox' => \BoltPay\Bolt::$isSandboxMode
]);


$exampleData = new \BoltPay\Example\Data();
$cartData = $exampleData->generateCart();
$cartItems = @$cartData['cart']['items'];
$currency = @$cartData['cart']['currency'];
$discounts = @$cartData['cart']['discounts'];
$grandTotal = @$cartData['cart']['total_amount'];

/** @var \BoltPay\Http\Response $response */
$response = $client->createOrder($cartData);
$orderToken = $response->isResponseSuccessful()  ? @$response->getBody()->token : '';
?>


<html>
<head>
    <title>Bolt php library demo</title>

    <?= \BoltPay\Helper::renderBoltTrackScriptTag(); ?>
    <?= \BoltPay\Helper::renderBoltConnectScriptTag(); ?>
    <style>
        * {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0 5%;
        }

        .cart-title h1 {
            font-size: 24px;
            font-family: 'OpenSans-Semibold';
            color: #1077b2;
            font-weight: 100;
        }

        .cart-title {
            margin-top: 50px;
        }

        .cart-content {
            overflow: hidden;
            max-width: 1224px;
        }

        .cart-content .cart-form {
            width: 70%;
            float: left;
        }

        .cart-content .cart-totals {
            width: 30%;
            float: left;
        }

        .cart-totals table, .cart-form table {
            border-collapse: collapse;
            width: 100%;
        }

        .cart-form {
            padding-right: 75px;
            box-sizing: border-box;
        }

        .cart-form .product-name {
            font-size: 15px;
            color: rgb(16, 119, 178);
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .cart-form .product-sku {
            font-style: italic;
            color: #636363;
        }

        .cart-form tr {
            border-bottom: 1px solid #dbdbdb;
            text-align: center;
        }

        .cart-form tr td:first-child,
        .cart-form tr th:first-child {
            text-align: left;
        }

        .cart-form tr td,
        .cart-form tr th {
            padding-bottom: 15px;
            font-size: 14px;
        }

        .cart-totals {
            padding: 10px 42px 50px;
            background-color: #eeeeee;
            border: 1px solid #cccccc;
            box-sizing: border-box;
        }

        .cart-totals p {
            text-align: left;
            padding-bottom: 8px;
            margin-top: 20px;
            font-size: 30px;
            font-family: 'Open Sans';
            color: rgb(110, 110, 110);
            border-bottom: 1px solid #dbdbdb;
        }

        .cart-totals table tr td {
            padding-bottom: 5px;
            text-transform: uppercase;
        }

        .cart-totals table tr td:first-child {
            font-size: 15px;
            font-weight: 400;
            text-align: left;
        }

        .cart-totals table tr td:nth-child(2) {
            font-size: 13px;
            font-weight: 400;
            text-align: right;
        }

        .cart-totals table tr.grand-total td {
            font-size: 15px;
            font-weight: 400;
        }

        div.bolt-checkout-button div.bolt-checkout-button-button img {
            margin-top: 0;
            padding: 12px 10px;
        }


    </style>
</head>
<body>

<div class="cart-title">
    <h1>SHOPPING CART</h1>
</div>
<div class="cart-content">
    <form action="" class="cart-form" method="post">
        <table>
            <tr>
                <th>PRODUCT NAME</th>
                <th>UNIT PRICE</th>
                <th>QTY</th>
                <th>SUBTOTAL</th>
            </tr>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td>
                        <div class="product-name">
                            <?= @$item['name'] ?>
                        </div>
                        <div class="product-sku">
                            <span>Sku:</span>
                            <?= @$item['sku'] ?>
                        </div>
                    </td>
                    <td><?= $exampleData->getPriceDisplay(@$item['unit_price'] , $currency)?></td>
                    <td><?= @$item['quantity'] ?></td>
                    <td><?= $exampleData->getPriceDisplay(@$item['total_amount'] , $currency)?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>

    <div class="cart-totals">
        <p>Summary</p>
        <table>
            <?php foreach ($discounts as $discount) : ?>
                <tr>
                    <td><?= @$discount['description'] ?></td>
                    <td>
                        -<?= $exampleData->getPriceDisplay(@$discount['amount'] , $currency)?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="grand-total">
                <td>
                    <strong>GRAND TOTAL</strong>
                </td>
                <td>
                    <strong><?= $exampleData->getPriceDisplay($grandTotal , $currency)?></strong>
                </td>
            </tr>
        </table>
        <div class="bolt-checkout-button with-cards"></div>
    </div>

</div>

<script>
    var cart = {
        "orderToken": "<?= $orderToken;?>",
        "authcapture": <?= $exampleData->getAuthCaptureConfig()?>
    };
    var hints = {};
    var callbacks = {
        check: function () {
            // This function is called just before the checkout form loads.
            // This is a hook to determine whether Bolt can actually proceed
            // with checkout at this point. This function MUST return a boolean.
            return true;
        },

        onCheckoutStart: function () {
            // This function is called after the checkout form is presented to the user.
        },

        onShippingDetailsComplete: function () {
            // This function is called when the user proceeds to the shipping options page.
            // This is applicable only to multi-step checkout.
        },

        onShippingOptionsComplete: function () {
            // This function is called when the user proceeds to the payment details page.
            // This is applicable only to multi-step checkout.
        },

        onPaymentSubmit: function () {
            // This function is called after the user clicks the pay button.
        },

        success: function (transaction, callback) {
            // This function is called when the Bolt checkout transaction is successful.
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", "<?=$saveOrderUrl?>", true);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == XMLHttpRequest.DONE && xmlhttp.status == 200) {

                    responseData = JSON.parse(xmlhttp.responseText);
                    orderCompleted = true;
                    callback();
                }
            };
            xmlhttp.send(JSON.stringify({reference: transaction.reference}));
        },

        close: function () {
            // This function is called when the Bolt checkout modal is closed.

            if (orderCompleted) {
                if (typeof responseData.confirmation_url !== 'undefined' && responseData.confirmation_url) {
                    location.href = responseData.confirmation_url;
                } else {
                    location.href = '<?=$successUrl?>';
                }
            }
        }
    };
    BoltCheckout.configure(cart, hints, callbacks);
</script>

</body>
</html>