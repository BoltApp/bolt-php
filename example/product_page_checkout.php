<?php
/** Render valid HTML with bolt checkout button */
require(dirname(__FILE__) . '/init_example.php');
?>
<html>
<head>
    <title>Bolt php library demo</title>

    <?= \BoltPay\Helper::renderBoltTrackScriptTag(); ?>
    <?= \BoltPay\Helper::renderBoltConnectScriptTag(); ?>
</head>
<style>
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
    }

    .price {
        color: grey;
        font-size: 22px;
    }

    .card button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    .card button:hover {
        opacity: 0.7;
    }
</style>
<body>
<h2 style="text-align:center">Product Detail Page </h2>

<div class="card">
    <h1>Sample Bolt product 1</h1>
    <p class="price">$100</p>
    <p>Some text about the product. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum.</p>
    <input type="number" id="quantity" name="quantity" onchange="setUpProductDetailPage()" value="1">
    <p>
    <div class="bolt-product-checkout-button bolt-multi-step-checkout"></div>
    </p>
</div>

<script>
    var setUpProductDetailPage = function () {
        var cart = {
            items: [
                {
                    reference: "123",
                    quantity: Number(document.getElementById('quantity').value),
                },
            ],
            currency: "USD",
        };
        var buttonClass = "bolt-product-checkout-button";
        var hints = {};
        var callbacks = {
            check: function () {
                return true;
            },
            onCheckoutStart: function () {
            },
            onShippingDetailsComplete: function () {
            },
            onShippingOptionsComplete: function () {
            },
            onPaymentSubmit: function () {
            },
            success: function (transaction, callback) {
                callback();
            },
            close: function () {
            }
        };
        BoltCheckout.configureProductCheckout(cart, hints, callbacks, {checkoutButtonClassName: buttonClass});
    }
    setUpProductDetailPage();
</script>
</body>
</html>